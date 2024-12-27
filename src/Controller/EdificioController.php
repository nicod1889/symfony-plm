<?php

namespace App\Controller;

use App\Entity\Edificio;
use App\Form\EdificioType;
use App\Repository\EdificioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/edificio')]
class EdificioController extends AbstractController {
    #[Route('/', name: 'app_edificio_index', methods: ['GET'])]
    public function index(EdificioRepository $edificioRepository): Response {
        return $this->render('edificio/index.html.twig', [
            'edificios' => $edificioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_edificio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $edificio = new Edificio();
        $form = $this->createForm(EdificioType::class, $edificio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($edificio);
            $entityManager->flush();

            return $this->redirectToRoute('app_edificio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('edificio/new.html.twig', [
            'edificio' => $edificio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_edificio_show', methods: ['GET'])]
    public function show(Edificio $edificio): Response {
        return $this->render('edificio/show.html.twig', [
            'edificio' => $edificio,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_edificio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Edificio $edificio, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(EdificioType::class, $edificio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_edificio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('edificio/edit.html.twig', [
            'edificio' => $edificio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_edificio_delete', methods: ['POST'])]
    public function delete(Request $request, Edificio $edificio, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete'.$edificio->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($edificio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_edificio_index', [], Response::HTTP_SEE_OTHER);
    }
}
