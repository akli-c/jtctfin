<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('content', TextareaType::class, [
            'label' => 'Laissez votre question',
            'attr' => [
                'placeholder' => 'Écrivez votre message ici ...',
            ]
        ])
        
        ->add('parentid', HiddenType::class, [
            'mapped'=> false
        ])
        ->add('send', SubmitType::class, [
            'label' =>'Envoyer',
            'attr' => [
                'class' => 'fw-bold btn btn-light border border-dark',
                'style' => 'font-family:Roboto'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
