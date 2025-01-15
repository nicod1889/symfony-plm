<?php

namespace App\Controller;

use App\Entity\Edicion;
use App\Form\EdicionType;
use App\Repository\EdicionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/edicion')]
class EdicionController extends AbstractController {
    #[Route('/', name: 'app_edicion_index', methods: ['GET'])]
    public function index(EdicionRepository $edicionRepository): Response {
        return $this->render('edicion/index.html.twig', [
            'edicions' => $edicionRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_edicion_show', methods: ['GET'])]
    public function show(Edicion $edicion): Response {
        return $this->render('edicion/show.html.twig', [
            'edicion' => $edicion,
        ]);
    }
}