<?php

namespace App\Form;

use App\Entity\Collecte;
use App\Entity\Don;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CollecteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options ): void
    {
        $builder

            ->add('etatC', ChoiceType::class, [
                'label' => 'Etat du collecte',
                'choices' => [
                    'en cour' => 1,
                    'valide' => 2,

                ],
            ])
            ->add('typevehicule')
            ->add('contact')
             ->add('idusercollect', EntityType::class, [
                 'label' => 'don',
                 'class' => User::class,
                 'choice_label' => 'email',
                 'required' => false
             ])
            ->add('iddon' , EntityType::class, [
                'label' => 'don',
                'class' => Don::class,
                'choice_label' => 'id',
                'required' => false
            ])
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Collecte::class,
        ]);
    }
}
