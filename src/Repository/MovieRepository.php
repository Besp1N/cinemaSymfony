<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    // MovieRepository.php

    public function findUniqueGenres(): array
    {
        return $this->createQueryBuilder('m')
            ->select('DISTINCT m.genre')
            ->getQuery()
            ->getResult();
    }

    public function findMovieByTitle(string $title, int $limit, int $page): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.title LIKE :title')
            ->setParameter('title', '%'.$title.'%')
            ->getQuery()
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit)
            ->getResult();
    }



//    /**
//     * @return Movie[] Returns an array of Movie objects
//     */
//    public function findByExampleField($movieId, $cinemaId): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.cinema = :val')
//            ->setParameter('val', $cinemaId)
//            ->andWhere('m.movie = :val')
//            ->setParameter('val', $movieId)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Movie
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
