<?php

namespace App\Repository;

use App\Entity\Faq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Faq>
 */
class FaqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Faq::class);
    }

    /**
     * @return Faq[]
     */
    public function findActives(): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.actif = true')
            ->orderBy('f.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
