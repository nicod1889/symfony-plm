<?php

namespace App\Repository;

use App\Entity\Programa;
use App\Entity\Edicion;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @extends ServiceEntityRepository<Programa>
 */
class ProgramaRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Programa::class);
    }

    public function findLatest(int $page = 1, string $search = '', ?Edicion $edicion = null): Paginator {
        $qb = $this->createQueryBuilder('p')
        ->orderBy('p.id', 'ASC');

        if ($search) {
            $qb->andWhere('p.titulo LIKE :search')
            ->setParameter('search', '%' . $search . '%');
        }

        if ($edicion) {
            $qb->andWhere('p.edicionClass = :edicion')
            ->setParameter('edicion', $edicion);
        }

        return (new Paginator($qb))->paginate($page);
    }
    

    //    /**
    //     * @return Programa[] Returns an array of Programa objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Programa
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}