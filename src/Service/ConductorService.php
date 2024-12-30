<?php

namespace App\Service;

use App\Entity\Conductor;
use Doctrine\ORM\EntityManagerInterface;

class ConductorService {
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
   
}