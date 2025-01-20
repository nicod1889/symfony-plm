<?php

namespace App\Controller;

use App\Repository\ProgramaRepository;
use App\Repository\EdicionRepository;
use App\Repository\Persona3Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController {
    #[Route('/', name: 'home_index', methods: ['GET'])]
    public function index(ProgramaRepository $programaRepository, EdicionRepository $edicionRepository, Persona3Repository $persona3Repository): Response {
        $programa = $programaRepository->findLastProgram();
        $ediciones = $edicionRepository->findByTipo('vlog');
        $conductores = $persona3Repository->findConductores();

        return $this->render('home/index.html.twig', [
            'programa' => $programa,
            'ediciones' => $ediciones,
            'conductores' => $conductores
        ]);
    }
}