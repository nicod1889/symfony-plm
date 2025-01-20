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

    public function findLatest(int $page = 1, string $search = '', ?Edicion $edicion = null, ?\DateTimeInterface $startDate = null, ?\DateTimeInterface $endDate = null, ?int $columnistaId = null, ?int $conductorId = null): Paginator {
        $qb = $this->createQueryBuilder('p')
        ->orderBy('p.fecha', 'ASC');

        if ($search) {
            $qb->andWhere('p.titulo LIKE :search')
            ->setParameter('search', '%' . $search . '%');
        }

        if ($edicion) {
            $qb->andWhere('p.edicionClass = :edicion')
            ->setParameter('edicion', $edicion);
        }

        if ($startDate) {
            $qb->andWhere('p.fecha >= :startDate')
                ->setParameter('startDate', $startDate->format('Y-m-d'));
        }
    
        if ($endDate) {
            $qb->andWhere('p.fecha <= :endDate')
                ->setParameter('endDate', $endDate->format('Y-m-d'));
        }

        if ($columnistaId) {
            $qb->leftJoin('p.columnistas', 'c')
                ->andWhere('c.id = :columnistaId')
                ->setParameter('columnistaId', $columnistaId);
        }

        if ($conductorId) {
            $qb->leftJoin('p.conductores', 'cond')
                ->andWhere('cond.id = :conductorId')
                ->setParameter('conductorId', $conductorId);
        }

        return (new Paginator($qb))->paginate($page);
    }

    public function findLastProgram(): ?Programa {
        return $this->createQueryBuilder('p')
            ->orderBy('p.fecha', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByYear(int $page = 1, int $year): Paginator {
        $startDate = new \DateTime("$year-01-01");
        $endDate = new \DateTime("$year-12-31");

        $qb = $this->createQueryBuilder('p')
                    ->andWhere('p.fecha BETWEEN :start AND :end')
                    ->setParameter('start', $startDate)
                    ->setParameter('end', $endDate)
                    ->orderBy('p.fecha', 'ASC');

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