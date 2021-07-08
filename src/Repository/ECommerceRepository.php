<?php

namespace App\Repository;

use App\Entity\ECommerce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ECommerce|null find($id, $lockMode = null, $lockVersion = null)
 * @method ECommerce|null findOneBy(array $criteria, array $orderBy = null)
 * @method ECommerce[]    findAll()
 * @method ECommerce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ECommerceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ECommerce::class);
    }

    // /**
    //  * @return ECommerce[] Returns an array of ECommerce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ECommerce
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
