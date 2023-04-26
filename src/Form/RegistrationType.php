<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'attr' => ['placeholder'=>'Enter the email adress','class' => 'form-control'],
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['placeholder'=>'Enter the lastname','class' => 'form-control'],
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['placeholder'=>'Enter the firstname','class' => 'form-control'],
            ])
            ->add('phone', IntegerType::class, [
                'attr' => ['placeholder'=>'Enter the phone number','class' => 'form-control'],
                'constraints' => new Length([
                    'min' => 8,
                    'minMessage' => 'Your phone number should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 10,
                ]),
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password','placeholder'=>'Enter the password','class' => 'form-control' ],
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
    
}
