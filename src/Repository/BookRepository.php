<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{

    use ProfileRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * @return Book[] Returns an array of Book objects
     */

    public function findByTheTitle($value)
    {
        $qb = $this->createQueryBuilder('b');

        return $qb->where($qb->expr()->like('b.title', ':value'))
        ->setParameter('value', "%{$value}%")
        ->orderBy('b.title', 'ASC')
        ->getQuery()
        ->getResult()
        ;
    }

    /**
     * @return Book[] Returns an array of Type objects
     */
    
    public function findByTheType(string $theType)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.types', 't')
            ->andWhere('t.name LIKE :theType')
            ->setParameter('theType', "%{$theType}%")
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    //     return $this->createQueryBuilder('b')
    //         ->andWhere('b.theTitle = :val')
    //         ->setParameter('val', {$value})
    //         ->orderBy('b.title', 'ASC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
