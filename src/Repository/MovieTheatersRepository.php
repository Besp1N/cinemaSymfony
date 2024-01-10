<?php

namespace App\Repository;

use App\Entity\MovieTheaters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MovieTheaters>
 *
 * @method MovieTheaters|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieTheaters|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieTheaters[]    findAll()
 * @method MovieTheaters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieTheatersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovieTheaters::class);
    }

//    /**
//     * @return MovieTheaters[] Returns an array of MovieTheaters objects
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

//    public function findOneBySomeField($value): ?MovieTheaters
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
