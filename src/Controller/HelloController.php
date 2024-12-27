<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends AbstractController {
    #[Route(path:"/hello", name:"hello-controller", methods : ["GET"])]
    public function __invoke(): Response {
        return $this->render('hello/hello.html.twig');
    }
}