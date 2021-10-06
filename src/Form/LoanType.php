<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Borrower;
use App\Entity\Loan;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class LoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('borrowing_date')
            ->add('return_date')
            ->add('borrower', EntityType::class, [
                // looks for choices from this entity
                'class' => Borrower::class,

                // uses the User.username property as the visible option string
                'choice_label' => function (Borrower $borrower) {
                    return "{$borrower->getFirstname()} {$borrower->getLastname()}";
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.firstname', 'ASC')
                    ;
                },
            ])
            ->add('book', EntityType::class, [
                // looks for choices from this entity
                'class' => Book::class,

                // uses the User.username property as the visible option string
                'choice_label' => function (Book $book) {
                    return "{$book->getTitle()}";
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.title', 'ASC')
                    ;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Loan::class,
        ]);
    }
}
