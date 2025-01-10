<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Edicion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Edicion>
 */
class EdicionRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Edicion::class);
    }

    public function findByTipo(string $tipo): array {
    return $this->createQueryBuilder('e')
        ->where('e.tipo = :tipo')
        ->setParameter('tipo', $tipo)
        ->getQuery()
        ->getResult();
    }

    public function findByNombre(string $nombre): ?Edicion {
    return $this->createQueryBuilder('e')
        ->where('e.nombre = :nombre')
        ->setParameter('nombre', $nombre)
        ->getQuery()
        ->getOneOrNullResult();
    }

    //    /**
    //     * @return Edicion[] Returns an array of Edicion objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Edicion
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}