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
    public function index(ProgramaRepository $programaRepository, EdicionRepository $edicionRepository, Persona3Repository $persona3Repository, int $page, Request $request): Response {
        $search = $request->query->get('search', '');
        $edicionId = $request->query->get('edicionId');
        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');
        $columnistaId = $request->query->get('columnistaId');
        $conductorId = $request->query->get('conductorId');

        $columnistaId = $columnistaId ? (int)$columnistaId : null;
        $conductorId = $conductorId ? (int)$conductorId : null;

        $startDate = $startDate ? \DateTime::createFromFormat('Y-m-d', $startDate) : null;
        $endDate = $endDate ? \DateTime::createFromFormat('Y-m-d', $endDate) : null;

        $ediciones = $edicionRepository->findByTipo('programa');
        $edicion = $edicionId ? $edicionRepository->find($edicionId) : null;

        $columnistas = $persona3Repository->findBy(['id' => range(5, 9)]);
        $conductores = $persona3Repository->findBy(['id' => range(1, 5)]);

        $programas = $programaRepository->findLatest($page, $search, $edicion, $startDate, $endDate, $columnistaId, $conductorId);

        return $this->render('programa/index.html.twig', [
            'paginator' => $programas,
            'ediciones' => $ediciones,
            'search' => $search,
            'selectedEdicionId' => $edicionId,
            'startDate' => $startDate ? $startDate->format('Y-m-d') : '',
            'endDate' => $endDate ? $endDate->format('Y-m-d') : '',
            'columnistas' => $columnistas,
            'selectedColumnistaId' => $columnistaId,
            'conductores' => $conductores,
            'selectedConductorId' => $conductorId
        ]);
    }

    #[Route('/{programYear<2022|2023|2024>}', name: 'programa_by_year', defaults: ['page' => 1], methods: ['GET'])]
    #[Route('/{programYear<2022|2023|2024>}/page/{page<[0-9]\d*>}', name: 'programaAno_index_paginated', methods: ['GET'])]
    public function programasPorAno(ProgramaRepository $programaRepository, EdicionRepository $edicionRepository, int $page, int $programYear): Response {
        $programas = $programaRepository->findByYear($page, $programYear);

        return $this->render('programa/ano.html.twig', [
            'paginator' => $programas,
            'year' => $programYear,
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
}