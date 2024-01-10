<?php

namespace App\Repository;

use App\Entity\MovieTheater;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MovieTheater>
 *
 * @method MovieTheater|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieTheater|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieTheater[]    findAll()
 * @method MovieTheater[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieTheaterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovieTheater::class);
    }

//    /**
//     * @return MovieTheater[] Returns an array of MovieTheater objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MovieTheater
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
