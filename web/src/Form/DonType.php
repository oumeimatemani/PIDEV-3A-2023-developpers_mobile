<?php
namespace App\Form;

use App\Entity\Don;
use App\Entity\User;
use App\Entity\CategorieD;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('poids', IntegerType::class, [
                'label' => 'Poids (en kg)',
                'required' => false
            ])
            ->add('descriptionD', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('etat', ChoiceType::class, [
                'label' => 'Etat du don',
                'choices' => [
                    'disponible' => 1,
                    'reserve' => 2,
                    'valide' => 3,

                ],
            ])
            ->add('date', DateType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'required' => false
            ])
           /* ->add('iduserdon', IntegerType::class, [
                'label' => 'Utilisateur donateur',
                 'class' => User::class,
                *'query_builder' => function (\Doctrine\ORM\EntityRepository $er) {
                     return $er->createQueryBuilder('u')
                         ->where('u.roles LIKE :roles')
                         ->setParameter('roles', '%"1"%')
                         ->orderBy('u.id', 'ASC');
                 },
                'choice_label' => 'email',
                'required' => false ,
                'data' => "1" ,
            ])*/
            ->add('idCategorie', EntityType::class, [
                'label' => 'Catégorie',
                'class' => CategorieD::class,
                'choice_label' => 'nom',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Don::class,
        ]);
    }
}
