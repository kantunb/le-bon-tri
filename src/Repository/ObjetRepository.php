<?php

namespace App\Repository;

use App\Entity\Objet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Objet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objet[]    findAll()
 * @method Objet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Objet::class);
    }

    // /**
    //  * @return Objet[] Returns an array of Objet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Objet
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByInvalidObjects()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.valide = false')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }
    /**
     *  @return Objet[] Retourne résultat de la recherche
     */
    public function findBySearchString($data)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.name LIKE :objetName')
            ->orderBy('b.name', 'ASC')
            ->setParameter('objetName', $data . '%')
            ->getQuery()
            ->getResult();
    }
}
