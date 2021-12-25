<?php

namespace App\Repository;

use App\Entity\WorkLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkLike[]    findAll()
 * @method WorkLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkLike::class);
    }

    // /**
    //  * @return WorkLike[] Returns an array of WorkLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkLike
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
