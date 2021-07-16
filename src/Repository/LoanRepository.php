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
        // Cette requête génère le code DQL suivant :
        // "SELECT u FROM App\Entity\User u WHERE u.roles LIKE :role ORDER BY u.email ASC"
        // 'u' sera l'alias qui permet de désigner un user.
        return $this->createQueryBuilder('l')
            // Ajout d'un filtre qui ne retient que les users
            // qui contiennent (opérateur LIKE) la chaîne de
            // caractères contenue dans la variable :role.
            ->andWhere('l.return_date < :date')
            // Affactation d'une valeur à la variable :role.
            // Le symbole % est joker qui veut dire
            // « match toutes les chaînes de caractères ».
            ->setParameter('date', "%{$date}%")
            // Tri par adresse email en ordre croissant (a, b, c, ...).
            ->orderBy('l.return_date', 'ASC')
            // Récupération d'une requête qui n'attend qu'à être exécutée.
            ->getQuery()
            // Exécution de la requête.
            // Récupération d'un tableau de résultat.
            // Ce tableau peut contenir, zéro, un ou plusieurs lignes.
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
