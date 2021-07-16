<?php

namespace App\Repository;

use App\Entity\Loan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Loan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Loan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Loan[]    findAll()
 * @method Loan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Loan::class);
    }

    /**
     * @return Loan[] Returns an array of Loan objects
     */
    public function findByReturnDate(string $date)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.return_date < :date')
            ->setParameter('date', "{$date}")
            ->orderBy('l.return_date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Loan[] Returns an array of Loan objects
     */
    public function findByBookId(int $id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.book', 'b')
            ->andWhere('b.id LIKE :id')
            ->setParameter('id', $id)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Loan[] Returns an array of Loan objects
     */
    public function findByBorrowerId(int $id)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.borrower', 'b')
            ->andWhere('b.id LIKE :id')
            ->setParameter('id', $id)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Loan[] Returns an array of Loan objects
     */
    
    public function findByTenLast()
    {
        return $this->createQueryBuilder('l')

        ->orderBy('l.borrowing_date', 'DESC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Loan
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
