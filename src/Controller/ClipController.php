<?php

namespace App\Controller;

use App\Entity\Clip;
use App\Form\ClipType;
use App\Repository\ClipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/clip')]
class ClipController extends AbstractController {
    #[Route('/', name: 'app_clip_index', methods: ['GET'])]
    public function index(ClipRepository $clipRepository): Response {
        return $this->render('clip/index.html.twig', [
            'clips' => $clipRepository->findAll(),
        ]);
    }
}
