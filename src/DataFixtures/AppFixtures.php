<?php

namespace App\DataFixtures;

// use App\Entity\type_book;
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
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
    }

    public function loadTypes(ObjectManager $manager)
    {
        $types = [];

        $type = new type();

        $type->setName('Science-fiction');
        $type->setDescription('Histoires avec plein de technologie');

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
    
        return $authors;

    }

    

    public function loadBooks(ObjectManager $manager, array $authors, array $types)
    {
        $books = [];

        $authorIndex = 0;

        $author = $authors[$authorIndex];

        $book = new Book();

        $book->setTitle('Le village');
        $book->setPublicationYear($this->faker->dateTimeThisCentury());
        $book->setNumberOfPages(155);
        $book->setIsbnCode('45ert486');
        $book->setAuthor($author);
        $book->addType($types[0]);
        
        $manager->persist($book);

        $books[] = $book;

        return $books;
    }

    public function loadBorrowers(ObjectManager $manager, int $count)
    {
        $borrowers = [];

        $user = new User();
        $user->setEmail('user1@example.com');
        $password = $this->encoder->encodePassword($user, '456');
        $user->setPassword($password);
        $user->setRoles(['ROLE_BORROWER']);

        $borrower = new Borrower();
        $borrower->setFirstname('John');
        $borrower->setLastname('Doe');
        $borrower->setPhone('0685421549');
        $borrower->setActive(true);
        $borrower->setCreationDate($this->faker->dateTimeThisDecade());
        $creationDate = $borrower->getCreationDate();
        $borrower->setUser($user);

        $manager->persist($borrower);

        $manager->persist($user);

        $user = new User();
        $user->setEmail('user2@example.com');
        $password = $this->encoder->encodePassword($user, '456');
        $user->setPassword($password);
        $user->setRoles(['ROLE_BORROWER']);

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

        $user = new User();
        $user->setEmail('user3@example.com');
        $password = $this->encoder->encodePassword($user, '456');
        $user->setPassword($password);
        $user->setRoles(['ROLE_BORROWER']);

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
            $password = $this->encoder->encodePassword($user, '456');
            $user->setPassword($password);
            $user->setRoles(['ROLE_BORROWER']);
    
            $manager->persist($user);

            $borrower = new Borrower();
            $borrower->setFirstname($this->faker->firstname());
            $borrower->setLastname($this->faker->lastname());
            $borrower->setPhone('0789564122');
            $borrower->setActive($this->faker->boolean());
            $borrower->setCreationDate($this->faker->dateTimeThisDecade());
            $creationDate = $borrower->getCreationDate();
            $borrower->setUser($user);

            $manager->persist($borrower);

            $borrowers[] = $borrower;
        }
        return $borrowers;
    }    

    public function loadLoans(ObjectManager $manager, array $borrowers, array $books)
    {
        $loans = [];

        $borrowerIndex = 0;
        $bookIndex = 0;

        $borrower = $borrowers[$borrowerIndex];
        $book = $books[$bookIndex];

        $loan = new Loan();
        $loan->setBorrowingDate($this->faker->dateTimeThisDecade());
        $borrowingDate = $loan->getBorrowingDate();
        $returnDate = \DateTime::createFromFormat('Y-m-d H:i:s', $borrowingDate->format('Y-m-d H:i:s'));
        $returnDate->add(new \DateInterval('P1M'));
        $loan->setReturnDate($returnDate);
        $loan->setBorrower($borrower);
        $loan->setBook($book);

        $manager->persist($loan);

        $loans[] = $loan;

        return $loans;
    }
}