<?php

namespace App\Repository;

use App\Entity\ScoreList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ScoreList|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScoreList|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScoreList[]    findAll()
 * @method ScoreList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScoreList::class);
    }

    // /**
    //  * @return ScoreList[] Returns an array of ScoreList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ScoreList
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
