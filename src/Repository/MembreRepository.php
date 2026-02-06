<?php

namespace App\Repository;

use App\Entity\Membre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Membre>
 */
class MembreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membre::class);
    }

    /**
     * @return Membre[]
     */
    public function findActifs(): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.actif = true')
            ->orderBy('m.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
