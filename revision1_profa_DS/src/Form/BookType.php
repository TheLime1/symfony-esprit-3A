<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref')
            ->add('title')
            ->add('publicationDate', null, [
                'widget' => 'single_text'
            ])
            
            ->add('category',ChoiceType::class,
            ['choices'=>[
                'SF'=>'Science Fiction',
                'M'=>'Mystery',
                'R'=>'Romance'
            ]])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'username',
                'placeholder'=>'Titre'
                // 'expanded'=>true,'multiple'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
