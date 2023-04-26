<?php

namespace App\Form\Type;

use App\Entity\Qna;
use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Votre réponse'
            ])
            ->add('qna', HiddenType::class)
            ->add('send', SubmitType::class, [
                'label' =>'Répondre'
            ]);
        
        // $builder->get('qna')
        // ->addModelTransformer(new CallbackTransformer(
        //     fn (Qna $qna) => $qna->getId(),
        //     fn (Qna $qna) => $qna->getContent()
        // ));
        }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> Answer::class,
            'csrf_token_id' => 'ans-add'
        ]);
    }

}