<?php

namespace App\Repository;

use App\Entity\Prestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<Prestation> */
class PrestationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestation::class);
    }

    /** @return Prestation[] */
    public function findActives(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.actif = true')
            ->orderBy('p.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
