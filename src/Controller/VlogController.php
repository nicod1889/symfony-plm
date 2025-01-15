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

    #[Route('/{id}', name: 'app_vlog_show', methods: ['GET'])]
    public function show(Vlog $vlog): Response {
        return $this->render('vlog/show.html.twig', [
            'vlog' => $vlog,
        ]);
    }
}