<?php

namespace App\Controller;

use App\Entity\Vlog;
use App\Form\VlogType;
use App\Repository\VlogRepository;
use App\Repository\EdicionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/vlog')]
class VlogController extends AbstractController {
    #[Route('/', name: 'app_vlog_index', methods: ['GET'])]
    public function index(VlogRepository $vlogRepository, EdicionRepository $edicionRepository, Request $request): Response {
        $edicionId = $request->query->get('edicionId');

        $ediciones = $edicionRepository->findByTipo('vlog');
        
        return $this->render('vlog/index.html.twig', [
            'vlogs' => $vlogRepository->findAll(),
            'ediciones' => $ediciones
        ]);
    }

    #[Route('/new', name: 'app_vlog_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $vlog = new Vlog();
        $form = $this->createForm(VlogType::class, $vlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vlog);
            $entityManager->flush();

            return $this->redirectToRoute('app_vlog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vlog/new.html.twig', [
            'vlog' => $vlog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vlog_show', methods: ['GET'])]
    public function show(Vlog $vlog): Response {
        return $this->render('vlog/show.html.twig', [
            'vlog' => $vlog,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vlog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vlog $vlog, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(VlogType::class, $vlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vlog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vlog/edit.html.twig', [
            'vlog' => $vlog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vlog_delete', methods: ['POST'])]
    public function delete(Request $request, Vlog $vlog, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete'.$vlog->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($vlog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vlog_index', [], Response::HTTP_SEE_OTHER);
    }
}