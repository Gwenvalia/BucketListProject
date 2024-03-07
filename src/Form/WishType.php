<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre du souhait'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description du souhait',
                'required' => false
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur du souhait'
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'required' => false,
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => '--- Sélectionnez une catégorie ---',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
            'trim' => true,
        ]);
    }
}
