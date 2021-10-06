<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Type;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('publication_year')
            ->add('number_of_pages')
            ->add('isbn_code')
            ->add('author', EntityType::class, [
                // looks for choices from this entity
                'class' => Author::class,

                // uses the User.username property as the visible option string
                'choice_label' => function (Author $author) {
                    return "{$author->getLastname()} {$author->getFirstname()}";
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.lastname', 'ASC')
                    ;
                },
            ])
            ->add('types', EntityType::class, [
                // looks for choices from this entity
                'class' => Type::class,

                // uses the User.username property as the visible option string
                'choice_label' => function (Type $type) {
                    return "{$type->getName()}";
                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC')
                    ;
                },
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
