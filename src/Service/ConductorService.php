<?php

namespace App\Service;

use App\Entity\Conductor;
use Doctrine\ORM\EntityManagerInterface;

class ConductorService {
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function crearConductores(): void {
        $conductor1 = new Conductor();
        $conductor1->setNombre('Lucas')
                   ->setApellido('Rodriguez')
                   ->setApodo('El streamer')
                   ->setCumple(new \DateTime('1989-05-12'))
                   ->setInstagram('lucas_instagram')
                   ->setTwitter('lucas_twitter')
                   ->setYoutube('lucas_youtube');
        
        $conductor2 = new Conductor();
        $conductor2->setNombre('Germán')
                   ->setApellido('Beder')
                   ->setApodo('El intrépido')
                   ->setCumple(new \DateTime('1990-03-05'))
                   ->setInstagram('gercho_instagram')
                   ->setTwitter('gercho_twitter')
                   ->setYoutube('gercho_youtube');
        
        $this->entityManager->persist($conductor1);
        $this->entityManager->persist($conductor2);

        $this->entityManager->flush();
    }
}
