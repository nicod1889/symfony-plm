<?php

namespace App\Controller;

use App\Entity\Invitado;
use App\Repository\InvitadoRepository;
use App\Form\InvitadoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/invitado')]
class InvitadoController extends AbstractController {
    #[Route('/', name: 'app_invitado_index', methods: ['GET'])]
    public function index(InvitadoRepository $invitadoRepository): Response {
        return $this->render('invitado/index.html.twig', [
            'invitados' => $invitadoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_invitado_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $invitado = new Invitado();
        $form = $this->createForm(InvitadoType::class, $invitado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($invitado);
            $entityManager->flush();

            return $this->redirectToRoute('app_invitado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invitado/new.html.twig', [
            'invitado' => $invitado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invitado_show', methods: ['GET'])]
    public function show(Invitado $invitado): Response {
        return $this->render('invitado/show.html.twig', [
            'invitado' => $invitado,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_invitado_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Invitado $invitado, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(InvitadoType::class, $invitado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_invitado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invitado/edit.html.twig', [
            'invitado' => $invitado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invitado_delete', methods: ['POST'])]
    public function delete(Request $request, Invitado $invitado, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete'.$invitado->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($invitado);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_invitado_index', [], Response::HTTP_SEE_OTHER);
    }
}
