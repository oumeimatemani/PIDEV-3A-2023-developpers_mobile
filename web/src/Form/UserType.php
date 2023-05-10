<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;


use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('email',EmailType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('password',TextType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('nom',TextType::class,
             ['attr' =>['class'=>'form-control']])
            ->add('prenom',TextType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('photo',TextType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('datenaissance', DateType::class, [
                'constraints' => [
                    new LessThanOrEqual([
                        'value' => 'today',
                        'message' => 'The date must be less than or equal to today\'s date.'
                    ])
                ],
            ])
            ->add('cin',TextareaType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('region',TextType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('ville',TextType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('adresse',TextType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('isactive',TextType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Donneur' => 'ROLE_DONNEUR',
                    'Collecteur'=>'ROLE_COLLECTEUR',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Rôles' 
                
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
