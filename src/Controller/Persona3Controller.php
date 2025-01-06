<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Persona3;
use App\Form\Persona3Type;
use App\Repository\Persona3Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/persona3')]
class Persona3Controller extends AbstractController
{
    #[Route('/', name: 'app_persona3_index', methods: ['GET'])]
    public function index(Persona3Repository $persona3Repository): Response
    {
        return $this->render('persona3/index.html.twig', [
            'persona3s' => $persona3Repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_persona3_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $persona3 = new Persona3();
        $form = $this->createForm(Persona3Type::class, $persona3);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($persona3);
            $entityManager->flush();

            return $this->redirectToRoute('app_persona3_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('persona3/new.html.twig', [
            'persona3' => $persona3,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_persona3_show', methods: ['GET'])]
    public function show(Persona3 $persona3): Response
    {
        return $this->render('persona3/show.html.twig', [
            'persona3' => $persona3,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_persona3_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Persona3 $persona3, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Persona3Type::class, $persona3);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_persona3_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('persona3/edit.html.twig', [
            'persona3' => $persona3,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_persona3_delete', methods: ['POST'])]
    public function delete(Request $request, Persona3 $persona3, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$persona3->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($persona3);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_persona3_index', [], Response::HTTP_SEE_OTHER);
    }
}
