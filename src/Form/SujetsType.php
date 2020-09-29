<?php

namespace App\Form;

use App\Entity\Sujets;
use App\Entity\Themes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SujetsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('titre', TextType::class, [
                'attr' => ['class' => 'uk-input']
            ])
            ->add('themes', EntityType::class, [
                'class' => Themes::class,
                'placeholder' => 'Choisir un Thème',
                'attr' => [
                    'class' => 'uk-input',
                ]
            ])

            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'uk-button uk-button-primary uk-margin-top']
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sujets::class,
             // enable/disable CSRF protection for this form
             'csrf_protection' => true,
             // the name of the hidden HTML field that stores the token
             'csrf_field_name' => '_token',
             // an arbitrary string used to generate the value of the token
             // using a different string for each form improves its security
             'csrf_token_id'   => 'sujets_item',
        ]);
    }
}
