<?php

namespace App\Controller;

use App\Entity\Vlog;
use App\Entity\Edicion;
use App\Form\VlogType;
use App\Repository\VlogRepository;
use App\Repository\EdicionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ParenseDeManos')]
class PDMController extends AbstractController {
    #[Route('/', name: 'app_pdm_index', methods: ['GET'])]
    public function index(VlogRepository $vlogRepository, EdicionRepository $edicionRepository, Request $request): Response { 
        $edicionId = $request->query->get('edicionId');
        $ediciones = $edicionRepository->findByTipo('pdm');
        $vlogs = $vlogRepository->findAll();
        
        return $this->render('pdm/index.html.twig', [
            'vlogs' => $vlogs,
            'ediciones' => $ediciones
        ]);
    }

    #[Route('/1', name: 'app_pdm1_show', methods: ['GET'])]
    public function show(Edicion $edicion): Response {
        return $this->render('edicion/show.html.twig', [
            'edicion' => $edicion,
        ]);
    }
}