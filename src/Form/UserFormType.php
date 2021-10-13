<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $familyType = [
            'Homme seul' => 'Homme seul',
            'Femme seule' => 'Femme seule',
            'Couple sans enfant' => 'Couple sans enfant',
            'Couple avec enfant' => 'Couple avec enfant'
        ];

        $builder
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Prénom',
                'attr' => [ 'placeholder' => 'Prénom' ]
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'attr' => [ 'placeholder' => 'Nom' ]
            ])
            ->add('familyType', ChoiceType::class, [
                'required' => false,
                'choices' => $familyType,
                'label' => 'typologie familiale',
                'attr' => [ 'placeholder' => 'typologie familiale' ]
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
                'label' => 'Date d\'anniversaire',
            ])

            ->add('send', SubmitType::class, [
                'label' => 'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
