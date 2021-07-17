<?php

namespace App\DataFixtures;

use App\Entity\Type;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Borrower;
use App\Entity\Loan;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;
    private $faker;


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = FakerFactory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        $borrowersCount = 100;
        $loansCount = 200;
        $numberOfBooks = 1000;
        $numberOfAuthors = 500;

        $this->loadAdmin($manager);
        $types = $this->loadTypes($manager);
        $borrowers = $this->loadBorrowers($manager, $borrowersCount);
        $authors = $this->loadAuthors($manager, $numberOfAuthors);
        $books = $this->loadBooks($manager, $authors, $types, $numberOfBooks);
        $loans = $this->loadLoans($manager, $borrowers, $books, $loansCount);

        $manager->flush();
    }

    public function loadAdmin(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('admin@example.com');
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $manager->persist($user);
    }

    public function loadTypes(ObjectManager $manager)
    {
        $types = [];

        $type = new type();
        $type->setName('Science-fiction');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('poésie');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('nouvelle');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('roman d\'histoire');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('roman d\'amour');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('rman d\'aventure');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('fantasy');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('biographie');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('conte');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('témoignage');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('théâtre');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('essai');
        $manager->persist($type);
        $types[] = $type;

        $type = new type();
        $type->setName('journal intime');
        $manager->persist($type);
        $types[] = $type;
    
        return $types;

    }

    public function loadAuthors(ObjectManager $manager, int $count)
    {
        $authors = [];

        $author = new author();
        $author->setFirstname('George');
        $author->setLastname('Karkata');

        $manager->persist($author);

        $authors[] = $author;

        for ($i = 1; $i < $count; $i++) {
            $author = new author();
            $author->setFirstname($this->faker->firstname());
            $author->setLastname($this->faker->lastname());
    
            $manager->persist($author);
    
            $authors[] = $author;
        }
    
        return $authors;

    }

    public function loadBooks(ObjectManager $manager, array $authors, array $types, int $count)
    {
        $books = [];
        $isbnList = [];
        $authorIndexList = [];

        $authorIndex = 0;
        $author = $authors[$authorIndex];

        $typeIndex = 0;

        $book = new Book();
        $book->setTitle('Le village');
        $book->setPublicationYear($this->faker->numberBetween($min = 1800, $max = 2021));
        $book->setNumberOfPages($this->faker->numberBetween($min = 50, $max = 600));
        $isbnC = $this->faker->numberBetween($min = 4589457823158, $max = 4589557823158);
        $book->setIsbnCode(strval($isbnC));
        $book->setAuthor($author);
        $book->addType($types[$typeIndex]);
        
        $manager->persist($book);

        $books[] = $book;
        
        $newIsbnC = $isbnC;
        
        // Ajout des données aléatoire pour les 1000 livres
        for ($i = 1; $i < $count; $i++) {

            $book = new Book();
            $book->setTitle($this->faker->realText($maxNbChars = 20, $indexSize = 2));
            $book->setPublicationYear($this->faker->numberBetween($min = 1800, $max = 2021));
            $book->setNumberOfPages($this->faker->numberBetween($min = 50, $max = 600));

            // Ajout de l'isbn_code unique 
            $lastIsbnC = $newIsbnC;
            array_push($isbnList, $lastIsbnC);
            $newIsbnC = $this->faker->numberBetween($min = 4589457823158, $max = 4589557823158);
            while(in_array($newIsbnC, $isbnList, true)) {
                $newIsbnC = $this->faker->numberBetween($min = 4589457823158, $max = 4589557823158);
            };
            $book->setIsbnCode(strval($newIsbnC));

            // Ajout des 500 auteurs réparti aléatoirement dans les livres en 2 étapes.
            $newAuthorIndex = $authorIndex;
            array_push($authorIndexList, $newAuthorIndex);
            $newAuthorIndex = $this->faker->numberBetween($min = 0, $max = 499);
            // étape 1: répartir tous les auteurs pour qu'ils soient attribué à au moins un livre.
            while(in_array($newAuthorIndex, $authorIndexList, true) && count($authorIndexList) != 500) {
                $newAuthorIndex = $this->faker->numberBetween($min = 0, $max = 499);
            }
            // étape 2: dès que tous les auteurs ont été réparti au moins une fois, il ne reste
            // plus qu'a attribué au restant des livres, des auteurs aléatoirement.
            if (count($authorIndexList) >= 500) {
                $newAuthorIndex = $this->faker->numberBetween($min = 0, $max = 499);
            };
            $author = $authors[$newAuthorIndex];
            $book->setAuthor($author);

            // répartition aléatoire du genre pour les 1000 livres.
            $typeIndex = $this->faker->numberBetween($min = 0, $max = 12);
            $book->addType($types[$typeIndex]);
            
            $manager->persist($book);

            $books[] = $book;
        }

        return $books;
    }

    public function loadBorrowers(ObjectManager $manager, int $count)
    {
        $borrowers = [];

        $user = new User();
        $user->setEmail('user1@example.com');
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER', 'ROLE_BORROWER']);

        $borrower = new Borrower();
        $borrower->setFirstname('John');
        $borrower->setLastname('Doe');
        $borrower->setPhone('0685421549');
        $borrower->setActive(true);
        $borrower->setCreationDate($this->faker->dateTimeThisYear());
        $creationDate = $borrower->getCreationDate();
        $borrower->setUser($user);

        $manager->persist($borrower);

        $manager->persist($user);

        $borrowers[] = $borrower;


        $user = new User();
        $user->setEmail('user2@example.com');
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER', 'ROLE_BORROWER']);

        $borrower = new Borrower();
        $borrower->setFirstname('Marcus');
        $borrower->setLastname('Stanton');
        $borrower->setPhone('0612845219');
        $borrower->setActive(true);
        $borrower->setCreationDate($this->faker->dateTimeThisDecade());
        $creationDate = $borrower->getCreationDate();
        $borrower->setUser($user);

        $manager->persist($borrower);

        $manager->persist($user);

        $borrowers[] = $borrower;


        $user = new User();
        $user->setEmail('user3@example.com');
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER', 'ROLE_BORROWER']);

        $manager->persist($user);

        $borrower = new Borrower();
        $borrower->setFirstname('Albert');
        $borrower->setLastname('Kalavitchy');
        $borrower->setPhone('0612457889');
        $borrower->setActive(true);
        $borrower->setCreationDate($this->faker->dateTimeThisDecade());
        $creationDate = $borrower->getCreationDate();
        $borrower->setUser($user);

        $manager->persist($borrower);

        $borrowers[] = $borrower;

        for ($i = 1; $i <= $count; $i++) {

            $user = new User();
            $user->setEmail($this->faker->email());
            $password = $this->encoder->encodePassword($user, '123');
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER', 'ROLE_BORROWER']);
    
            $manager->persist($user);

            $borrower = new Borrower();
            $borrower->setFirstname($this->faker->firstname());
            $borrower->setLastname($this->faker->lastname());
            $borrower->setPhone($this->faker->phoneNumber());
            $borrower->setActive($this->faker->boolean());
            $borrower->setCreationDate($this->faker->dateTimeThisYear());
            $creationDate = $borrower->getCreationDate();
            $borrower->setUser($user);

            $manager->persist($borrower);

            $borrowers[] = $borrower;
        }
        return $borrowers;
    }    

    public function loadLoans(ObjectManager $manager, array $borrowers, array $books, int $count)
    {
        $loans = [];        
       
        $bookIndex = 0;
        $borrowerIndex = 0;

        $borrower = $borrowers[$borrowerIndex];
        $book = $books[$bookIndex];

        $borrowerCreationDate = $borrower->getCreationDate();

        $loan = new Loan();
        $loan->setBorrowingDate($this->faker->dateTimeThisYear());
        $borrowingDate = $loan->getBorrowingDate();
        while ($borrowingDate < $borrowerCreationDate) {
            $loan->setBorrowingDate($this->faker->dateTimeThisyear());
            $borrowingDate = $loan->getBorrowingDate();
        };
        $returnDate = null;
        // \DateTime::createFromFormat('Y-m-d H:i:s', $borrowingDate->format('Y-m-d H:i:s'));
        // $returnDate->add(new \DateInterval('P1M'));
        // $loan->setReturnDate($returnDate);
        $loan->setBorrower($borrower);

        $loan->setBook($book);

        $manager->persist($loan);

        
        $loans[] = $loan;

        for ($i = 1; $i < $count; $i++) {
            $borrowerIndex = $this->faker->numberBetween($min = 0, $max = 102); 
            $borrower = $borrowers[$borrowerIndex];
            
            $bookIndex = $this->faker->numberBetween($min = 0, $max = 999);
            $book = $books[$bookIndex];

            $borrowerCreationDate = $borrower->getCreationDate();

            $loan = new Loan();
            $loan->setBorrowingDate($this->faker->dateTimeThisDecade());
            $borrowingDate = $loan->getBorrowingDate();
            while ($borrowingDate < $borrowerCreationDate) {
                $loan->setBorrowingDate($this->faker->dateTimeThisyear());
                $borrowingDate = $loan->getBorrowingDate();
            };
            $returnDate = \DateTime::createFromFormat('Y-m-d H:i:s', $borrowingDate->format('Y-m-d H:i:s'));
            $returnDate->add(new \DateInterval('P1M'));
            $loan->setReturnDate($returnDate);

            $loan->setBorrower($borrower);
            $loan->setBook($book);

            $manager->persist($loan);

            $loans[] = $loan;
        }

        return $loans;
    }
}
