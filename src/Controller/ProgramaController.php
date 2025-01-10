<?php

namespace App\Controller;

use App\Entity\Programa;
use App\Form\ProgramaType;
use App\Repository\ProgramaRepository;
use App\Repository\EdicionRepository;
use App\Repository\Persona3Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/programa')]
class ProgramaController extends AbstractController {
    #[Route('/', name: 'app_programa_index', defaults: ['page' => 1], methods: ['GET'])]
    #[Route('/page/{page<[0-9]\d*>}', name: 'programa_index_paginated', methods: ['GET'])]
    public function index(ProgramaRepository $programaRepository, EdicionRepository $edicionRepository, int $page, Request $request): Response {
        $search = $request->query->get('search', '');
        $edicionId = $request->query->get('edicionId');

        $ediciones = $edicionRepository->findByTipo('programa');
        $edicion = $edicionId ? $edicionRepository->find($edicionId) : null;

        $programas = $programaRepository->findLatest($page, $search, $edicion);

        return $this->render('programa/index.html.twig', [
            'paginator' => $programas,
            'ediciones' => $ediciones,
            'search' => $search,
            'selectedEdicionId' => $edicionId,
        ]);
    }

    #[Route('/presencias', name: 'app_programa_presencias', methods: ['GET'])]
    public function presencias(ProgramaRepository $programaRepository, Persona3Repository $persona3Repository): Response {
        $programas = $programaRepository->findAll();
       
        $conductorPresencias = [];
        $columnistaPresencias = [];
        $invitadoPresencias = [];
        foreach ($programas as $programa) {
            foreach ($programa->getConductores() as $conductor) {
                $conductorId = $conductor->getId();
                if (!isset($conductorPresencias[$conductorId])) {
                    $conductorPresencias[$conductorId] = 0;
                }
                $conductorPresencias[$conductorId]++;
            }
            foreach ($programa->getColumnistas() as $columnista) {
                $columnistaId = $columnista->getId();
                if (!isset($columnistaPresencias[$columnistaId])) {
                    $columnistaPresencias[$columnistaId] = 0;
                }
                $columnistaPresencias[$columnistaId]++;
            }
            foreach ($programa->getInvitados() as $invitado) {
                $invitadoId = $invitado->getId();
                if (!isset($invitadoPresencias[$invitadoId])) {
                    $invitadoPresencias[$invitadoId] = 0;
                }
                $invitadoPresencias[$invitadoId]++;
            }
        }
        
        $conductores = [];
        foreach ($conductorPresencias as $conductorId => $presencias) {
            $conductor = $persona3Repository->find($conductorId);
            if ($conductor) {
                $conductores[] = [
                    'nombre' => $conductor->getNombre(),
                    'presencias' => $presencias,
                ];
            }
        }
        usort($conductores, function($a, $b) {
            return $b['presencias'] - $a['presencias'];
        });

        $columnistas = [];
        foreach ($columnistaPresencias as $columnistaId => $presencias) {
            $columnista = $persona3Repository->find($columnistaId);
            if ($columnista) {
                $columnistas[] = [
                    'nombre' => $columnista->getNombre(),
                    'presencias' => $presencias    
                ];
            }
        }
        usort($columnistas, function($a, $b) {
            return $b['presencias'] - $a['presencias'];
        });

        $invitados = [];
        foreach ($invitadoPresencias as $invitadoId => $presencias) {
            $invitado = $persona3Repository->find($invitadoId);
            if ($invitado) {
                $invitados[] = [
                    'nombre' => $invitado->getNombre(),
                    'presencias' => $presencias    
                ];
            }
        }
        usort($invitados, function($a, $b) {
            return $b['presencias'] - $a['presencias'];
        });

        return $this->render('programa/presencias.html.twig', [
            'conductores' => $conductores,
            'columnistas' => $columnistas,
            'invitados' => $invitados
        ]);
    }

    #[Route('/new', name: 'app_programa_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $programa = new Programa();
        $form = $this->createForm(ProgramaType::class, $programa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($programa);
            $entityManager->flush();

            return $this->redirectToRoute('app_programa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('programa/new.html.twig', [
            'programa' => $programa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_programa_show', methods: ['GET'])]
    public function show(Programa $programa): Response {
        return $this->render('programa/show.html.twig', [
            'programa' => $programa,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_programa_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Programa $programa, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(ProgramaType::class, $programa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_programa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('programa/edit.html.twig', [
            'programa' => $programa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_programa_delete', methods: ['POST'])]
    public function delete(Request $request, Programa $programa, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete'.$programa->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($programa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_programa_index', [], Response::HTTP_SEE_OTHER);
    }

}