<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Loan;
use App\Entity\Type;
use App\Entity\User;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\BorrowerRepository;
use App\Repository\LoanRepository;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(
        AuthorRepository $authorRepository,
        BookRepository $bookRepository,
        BorrowerRepository $borrowerRepository,
        LoanRepository $loanRepository,
        TypeRepository $typeRepository,
        UserRepository $userRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $books = $bookRepository->findAll();
        foreach($books as $book) {
        $isBook = $book->getTypes();
        dump($isBook);
        exit();
        }

        // LES UTILISATEURS 
        // >>> Requêtes de lecture :

        // la liste complète de tous les utilisateurs (de la table `user`)
        $users = $userRepository->findAllUsers();
        dump($users);

        // Récupération du user dont l'id est 1.
        $user = $userRepository->find(1);
        dump($user);

        // Récupération de l'utilisateur d'une adresse email spécifique
        $email = 'user1@example.com';
        $userEmail = $userRepository->findByTheEmail($email);
        dump($userEmail);

        // les données des utilisateurs dont l'attribut `roles` contient le mot clé `ROLE_BORROWER`
        $emprunteur = $userRepository->findByRole('ROLE_BORROWER');
        dump($emprunteur);

        

        // LES LIVRES
        // >>> Requêtes de lecture :

        // La liste complète de tous les livres
        $books = $bookRepository->findAll();
        dump($books);

        // Les données du livre dont l'id est `1`
        $book = $bookRepository->find(1);
        dump($book);

        // la liste des livres dont le titre contient le mot clé `elle`
        $title = 'elle';
        $booksTitle = $bookRepository->findByTheTitle($title);
        dump($booksTitle);
    
        // La liste des livres dont l'id de l'auteur est `2`
        $authors = $authorRepository->find(2);
        foreach ($authors->getBooks() as $authorsBook) {
            dump($authorsBook);
        }

        // La liste des livres dont le genre contient le mot clé `roman`
        $theType = "roman";
        $booksType = $bookRepository->findByTheType($theType);
        dump($booksType);

        
        // >>> Requêtes de création :

        // Ajout d'un nouveau livre
        $author = $authorRepository->find(2);
        $type = $typeRepository->find(1);
        $book = new Book();
        $book->setTitle('Totum autem id externum');
        $book->setPublicationYear('2020');
        $book->setNumberOfPages('300');
        $isbnC = '9790412882714';
        $book->setIsbnCode(strval($isbnC));
        $book->setAuthor($author);
        $book->addType($type);
        $entityManager->persist($book);
        $entityManager->flush();
        dump($book);

        
        // >>> Requêtes de mise à jour :

        // -> modifier le livre dont l'id est `2` 
        $book = $bookRepository->find(2);
        if ($book) {
            // -> titre : Aperiendum est igitur 
            $book->setTitle('Aperiendum est igitur');
            //-> genre : roman d'aventure (id `6`)
            foreach ($book->getTypes() as $bookType) {
            }
            $book->removeType($bookType);
            $type = $typeRepository->find(1);
            $book->addType($type);
            $entityManager->flush();
            dump($book);
        }

        // >>> Requêtes de suppression :

        // Supprimer le livre dont l'id est `123`
        $book = $bookRepository->find(123);
        $entityManager->remove($book);
        $entityManager->flush();
                       

        
        // LES EMPRUNTEURS
        // >>> Requêtes de lecture :

        // La liste complète des emprunteurs
        $borrowers = $borrowerRepository->findAll();
        dump($borrowers);

        // Les données de l'emprunteur dont l'id est `3`
        $borrower = $borrowerRepository->find(3);
        dump($borrower);

        // Les données de l'emprunteur qui est relié au user dont l'id est `3`
        $borrower = $borrowerRepository->findByUserId(3);
        dump($borrower);

        // La liste des emprunteurs dont le nom ou le prénom contient le mot clé `Albert`
        $name = 'Albert';
        $borrowersName = $borrowerRepository->findByFirstnameOrLastname($name);
        dump($borrowersName);

        // La liste des emprunteurs dont le téléphone contient le mot clé `1245`
        $numb = '1245';
        $numbSearch = $borrowerRepository->findByTheNumb($numb);
        dump($numbSearch);

        // La liste des emprunteurs dont la date de création est antérieure au 01/03/2021 exclu (c-à-d strictement plus petit)
        $date = '2021-03-01 00:00:00';
        dump($date);
        $dateSearch = $borrowerRepository->findByCreationDate($date);
        dump($dateSearch);

        // La liste des emprunteurs inactifs (c-à-d dont l'attribut `actif` est égal à `false`)
        $isActive = false;
        $isNotActive = $borrowerRepository->findByActive($isActive);
        dump($isNotActive);



        // LES EMPRUNTS
        // >>> Requêtes de lecture :

        // La liste des 10 derniers emprunts au niveau chronologique
        $tenLastLoans = $loanRepository->findByTenLast();
        dump($tenLastLoans);

        // La liste des emprunts de l'emprunteur dont l'id est `2`
        $loans = $loanRepository->findByBorrowerId(2);
        dump($loans);

        // La liste des emprunts du livre dont l'id est `55`
        $loans = $loanRepository->findByBookId(55);
        dump($loans);

        // La liste des emprunts qui ont été retournés avant le 01/01/2021
        $date = '2021-07-16 00:00:00';
        $bookReturned = $loanRepository->findByReturnDate($date);
        dump($bookReturned);

        // La liste des emprunts qui n'ont pas encore été retournés (c-à-d dont la date de retour est nulle)
        $loanNull = $loanRepository->findAll();
        foreach($loanNull as $returnDateNull) {
            $isNull = $returnDateNull->getReturnDate();
            if ($isNull == null){
                dump($returnDateNull);
            }
        }
        
        // Les données de l'emprunt du livre dont l'id est `3` et qui n'a pas encore été retournés (c-à-d dont la date de retour est nulle)
        $loanNull = $loanRepository->find(1);
        dump($loanNull);


        // >>> Requêtes de création :

        // Ajouter un nouvel emprunt
        $loan = new Loan();
        // Livre : (id `1`)
        $book = $bookRepository->find(1);
        $loan->setBook($book);
        // Emprunteur : (id `1`)
        $borrower = $borrowerRepository->find(1);
        $loan->setBorrower($borrower);
        // Date d'emprunt : 01/12/2020 à 16h00
        $loan->setBorrowingDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-12-01 16:00:00'));
        // Date de retour : aucune date
        $returnDate = null;
        $entityManager->persist($loan);
        $entityManager->flush();
        dump($loan);


        // >>> Requêtes de mise à jour :

        // Modifier l'emprunt dont l'id est `1`
        $loan = $loanRepository->find(1);
        // Date de retour : 01/05/2020 à 10h00
        $loan->setReturnDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-05-01 10:00:00'));
        dump($loan);

        // >>> Requêtes de suppression :
    
        // Supprimer l'emprunt dont l'id est `42`
        $loan = $loanRepository->find(42);
        $entityManager->remove($loan);
        $entityManager->flush();

        exit();
    }
}
