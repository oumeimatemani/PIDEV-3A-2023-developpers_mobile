<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomP')
            ->add('prixP')
            ->add('descriptionP')
            ->add('imageP',FileType::class,array("data_class"=>null))
            ->add('stock')

            ->add('idcatP',EntityType::class,
                array(
                    'class'=> 'App\Entity\CategorieP',
                    'choice_label'=>'nomC',
                    'multiple'=>false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
