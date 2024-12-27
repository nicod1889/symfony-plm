<?php

namespace App\Controller;

use App\Entity\Conductor;
use App\Repository\ConductorRepository;
use App\Form\ConductorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/conductor')]
class ConductorController extends AbstractController {
    #[Route('/', name: 'app_conductor_index', methods: ['GET'])]
    public function index(ConductorRepository $conductorRepository): Response {
        return $this->render('conductor/index.html.twig', [
            'conductors' => $conductorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_conductor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $conductor = new Conductor();
        $form = $this->createForm(ConductorType::class, $conductor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($conductor);
            $entityManager->flush();

            return $this->redirectToRoute('app_conductor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('conductor/new.html.twig', [
            'conductor' => $conductor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_conductor_show', methods: ['GET'])]
    public function show(Conductor $conductor): Response {
        return $this->render('conductor/show.html.twig', [
            'conductor' => $conductor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_conductor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Conductor $conductor, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(ConductorType::class, $conductor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_conductor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('conductor/edit.html.twig', [
            'conductor' => $conductor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_conductor_delete', methods: ['POST'])]
    public function delete(Request $request, Conductor $conductor, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete'.$conductor->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($conductor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_conductor_index', [], Response::HTTP_SEE_OTHER);
    }
}
