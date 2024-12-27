<?php

namespace App\Controller;

use App\Entity\Persona2;
use App\Form\Persona2Type;
use App\Repository\Persona2Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/persona2')]
class Persona2Controller extends AbstractController {
    #[Route('/', name: 'app_persona2_index', methods: ['GET'])]
    public function index(Persona2Repository $persona2Repository): Response {
        return $this->render('persona2/index.html.twig', [
            'persona2s' => $persona2Repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_persona2_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $persona2 = new Persona2();
        $form = $this->createForm(Persona2Type::class, $persona2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($persona2);
            $entityManager->flush();

            return $this->redirectToRoute('app_persona2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('persona2/new.html.twig', [
            'persona2' => $persona2,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_persona2_show', methods: ['GET'])]
    public function show(Persona2 $persona2): Response {
        return $this->render('persona2/show.html.twig', [
            'persona2' => $persona2,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_persona2_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Persona2 $persona2, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(Persona2Type::class, $persona2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_persona2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('persona2/edit.html.twig', [
            'persona2' => $persona2,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_persona2_delete', methods: ['POST'])]
    public function delete(Request $request, Persona2 $persona2, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete'.$persona2->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($persona2);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_persona2_index', [], Response::HTTP_SEE_OTHER);
    }
}
