<?php

namespace App\Repository;

use App\Entity\Conductor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ConductorRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Conductor::class);
    }

    public function findByApodo(string $apodo): array {
        return $this->createQueryBuilder('c')
            ->andWhere('c.apodo = :apodo')
            ->setParameter('apodo', $apodo)
            ->getQuery()
            ->getResult();
    }
}