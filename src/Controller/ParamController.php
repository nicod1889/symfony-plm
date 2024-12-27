<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/params')]
class ParamController extends AbstractController {
    #[Route('/query', name:'get-query-params', methods: ['GET'])]
    public function getQueryParams(Request $request): Response {
        $name = $request->query->get("name");
        $email = $request->query->get("email");

        $items = ['uno', 'dos', 'tres', 'cuatro', 'cinco'];
    
        // return new JsonResponse(['name' => $name,'email'=> $email]);

        return $this->render('param/params.html.twig', [
            'name' => $name,
            'email' => $email,
            'items' => $items
        ]);
    }
}