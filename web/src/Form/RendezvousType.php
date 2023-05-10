<?php

namespace App\Form;

use App\Entity\Collecte;
use App\Entity\Rendezvous;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RendezvousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateRV')
            ->add('adresseRV')
            
            ->add('etatRV', ChoiceType::class, [
                'label' => 'Etat du RendezVous',
                'choices' => [
                    'en attente' => 1,
                    'terminé' => 2,

                ],
            ])

            ->add('idcollecte' , EntityType::class, [
                'label' => 'collecte',
                'class' => Collecte::class,
                'choice_label' => 'id',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rendezvous::class,
        ]);
    }
}
