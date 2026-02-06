<?php

namespace App\Repository;

use App\Entity\ChiffreCle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChiffreCle>
 */
class ChiffreCleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChiffreCle::class);
    }

    /**
     * @return ChiffreCle[]
     */
    public function findActifs(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.actif = true')
            ->orderBy('c.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
