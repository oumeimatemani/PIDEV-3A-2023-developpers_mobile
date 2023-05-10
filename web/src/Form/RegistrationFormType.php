<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;



use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

use Google\Recaptcha\V2\ReCaptchaValidator;
use Google\Recaptcha\V2\ReCaptcha;
use Google\Recaptcha\V3\ReCaptchaV3;


use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;








class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           
            ->add('email',EmailType::class,
            ['attr'=>['class'=>'form-control']])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('nom',TextType::class,
             ['attr' =>['class'=>'form-control']])
            ->add('prenom',TextType::class,
            ['attr' =>['class'=>'form-control']])
            
            ->add('datenaissance', DateType::class, [
                'constraints' => [
                    new LessThanOrEqual([
                        'value' => 'today',
                        'message' => 'The date must be less than or equal to today\'s date.'
                    ])
                ],
            ])
            ->add('cin',TextType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('region',TextType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('ville',TextType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('adresse',TextType::class,
            ['attr' =>['class'=>'form-control']])
            ->add('recaptcha3', Recaptcha3Type::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}




