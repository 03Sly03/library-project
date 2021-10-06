<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Borrower;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Borrower|null find($id, $lockMode = null, $lockVersion = null)
 * @method Borrower|null findOneBy(array $criteria, array $orderBy = null)
 * @method Borrower[]    findAll()
 * @method Borrower[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BorrowerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borrower::class);
    }

    /**
     * @return Borrower[] Returns an array of Borrower objects
     */
    public function findByUserId(int $id)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.user', 'u')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Borrower[] Returns an array of Borrower objects
     */
    public function findByActive(string $isActive)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.active = :isActive')
            ->setParameter('isActive', "%{$isActive}%")
            ->orderBy('b.lastname', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Borrower[] Returns an array of Borrower objects
     */
    public function findByCreationDate(string $date)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.creation_date < :date')
            ->setParameter('date', "{$date}")
            ->orderBy('b.creation_date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Borrower[] Returns an array of Borrower objects
     */
    
    public function findByTheNumb($value)
    {
        $qb = $this->createQueryBuilder('b');

        return $qb->where($qb->expr()->like('b.phone', ':value'))
        ->setParameter('value', "%{$value}%")
        ->orderBy('b.lastname', 'ASC')
        ->getQuery()
        ->getResult()
        ;
    }

    /**
     * @return Borrower[] Returns an array of Borrower objects
     */

    public function findByFirstnameOrLastname($value)
    {
        // Récupération d'un query builder.
        $qb = $this->createQueryBuilder('b');
        return $qb->where($qb->expr()->orX(
                $qb->expr()->like('b.firstname', ':value'),
                $qb->expr()->like('b.lastname', ':value')
            ))
            ->setParameter('value', "%{$value}%")
            ->orderBy('b.firstname', 'ASC')
            ->orderBy('b.lastname', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Borrower
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
