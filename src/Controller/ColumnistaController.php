<?php

namespace App\Controller;

use App\Entity\Columnista;
use App\Repository\ColumnistaRepository;
use App\Form\ColumnistaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/columnista')]
class ColumnistaController extends AbstractController
{
    #[Route('/', name: 'app_columnista_index', methods: ['GET'])]
    public function index(ColumnistaRepository $columnistaRepository): Response
    {
        return $this->render('columnista/index.html.twig', [
            'columnistas' => $columnistaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_columnista_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $columnistum = new Columnista();
        $form = $this->createForm(ColumnistaType::class, $columnistum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($columnistum);
            $entityManager->flush();

            return $this->redirectToRoute('app_columnista_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('columnista/new.html.twig', [
            'columnistum' => $columnistum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_columnista_show', methods: ['GET'])]
    public function show(Columnista $columnistum): Response
    {
        return $this->render('columnista/show.html.twig', [
            'columnistum' => $columnistum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_columnista_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Columnista $columnistum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ColumnistaType::class, $columnistum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_columnista_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('columnista/edit.html.twig', [
            'columnistum' => $columnistum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_columnista_delete', methods: ['POST'])]
    public function delete(Request $request, Columnista $columnistum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$columnistum->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($columnistum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_columnista_index', [], Response::HTTP_SEE_OTHER);
    }
}
