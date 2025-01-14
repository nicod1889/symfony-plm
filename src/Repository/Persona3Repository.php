<?php

namespace App\Repository;

use App\Entity\Persona3;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Persona3>
 */
class Persona3Repository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Persona3::class);
    }

    public function findConductores(): array {
        return $this->createQueryBuilder('p')
            ->setMaxResults(5)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findColumnistas(): array {
        $ids = [6, 7, 8, 5, 9, 10];
    
        $caseExpression = '';
        foreach ($ids as $index => $id) {
            $caseExpression .= "WHEN p.id = $id THEN $index ";
        }
    
        return $this->createQueryBuilder('p')
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Persona2
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}