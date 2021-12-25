<?php

namespace App\Repository;

use App\Entity\Usercategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Usercategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usercategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usercategory[]    findAll()
 * @method Usercategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsercategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usercategory::class);
    }

    // /**
    //  * @return Usercategory[] Returns an array of Usercategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Usercategory
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
