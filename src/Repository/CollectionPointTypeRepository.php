<?php

namespace App\Repository;

use App\Entity\CollectionPointType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CollectionPointType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CollectionPointType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CollectionPointType[]    findAll()
 * @method CollectionPointType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionPointTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CollectionPointType::class);
    }

    // /**
    //  * @return CollectionPointType[] Returns an array of CollectionPointType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CollectionPointType
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
