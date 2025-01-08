<?php

namespace App\Controller;

use App\Entity\Programa;
use App\Form\ProgramaType;
use App\Repository\ProgramaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/programa')]
class ProgramaController extends AbstractController {
    #[Route('/', name: 'app_programa_index', defaults: ['page' => '1'], methods: ['GET'])]
    #[Route('/page/{page<[0-9]\d*>}', name: 'programa_index_paginated', methods: ['GET'])]
    public function index(ProgramaRepository $programaRepository, int $page): Response {
        $programas = $programaRepository->findLatest($page);
    
        return $this->render('programa/index.html.twig', [
            'paginator' => $programas
        ]);
    }

    #[Route('/new', name: 'app_programa_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
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
    public function show(Programa $programa): Response
    {
        return $this->render('programa/show.html.twig', [
            'programa' => $programa,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_programa_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Programa $programa, EntityManagerInterface $entityManager): Response
    {
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
    public function delete(Request $request, Programa $programa, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programa->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($programa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_programa_index', [], Response::HTTP_SEE_OTHER);
    }
}