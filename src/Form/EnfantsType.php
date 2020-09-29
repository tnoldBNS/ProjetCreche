<?php

namespace App\Form;

use App\Entity\Enfants;
use App\Entity\Commissions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EnfantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => false,
            'attr' => [
            'class' => 'uk-input',
            'placeholder' => 'Nom']
        ])
        ->add('prenom', TextType::class, [
            'label' => false,
            'attr' => [
            'class' => 'uk-input',
            'placeholder' => 'Prenom']
        ])
        ->add('genre', ChoiceType::class, [
            'choices' => [
                'A selectionner' => "",
                'Masculin' => 'Masculin',
                'Feminin' => 'Feminin',
            ],
            'label' => 'Genre',
            'attr' => [
            'class' => 'uk-input']
        ])
        ->add('nationnalit', TextType::class, [
            'label' => false,
            'attr' => [
            'class' => 'uk-input',
            'placeholder' => 'Nationnalité']
        ])
        ->add('dateNaissance', DateType::class, [
            'widget' => 'single_text',
            'label' => 'Date de Naissance',
            'attr' => [
            'class' => 'uk-input',
            ]
        ]) 
           ->add('lieuNaissance', TextType::class, [
            'label' => false,
            'attr' => [
            'class' => 'uk-input espace',
            'placeholder' => 'Ville de Naissance']
        ])
        ->add('dateArrivee', DateType::class, [
            'widget' => 'single_text',
            'label' => "Date d'entrée",
            'attr' => [
            'class' => 'uk-input',]
        ])
        ->add('commissions', EntityType::class, [
            'class' => Commissions::class,
            'choice_label' => 'nomCommission',
            'attr' => [
                'class' => 'uk-input',
            ]
        ])
        ->add('rgpd', ChoiceType::class, [
                'choices' => [
                    'A selectionner' => "",
                    'Oui' => true,
                    'Non' => false,
                ],
                'label' => 'Droit de diffusion',
            'attr' => [
            'class' => 'uk-input',
            ]
        ])
        ->add('imageFile', FileType::class, [
            'label' => 'Selectionner un Symbole',
            'required' => false,
            'attr' => [
                'class' => 'uk-button ',
                'type' => "file"
            ]
        ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'uk-button uk-button-primary uk-margin-top']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enfants::class,
             // enable/disable CSRF protection for this form
             'csrf_protection' => true,
             // the name of the hidden HTML field that stores the token
             'csrf_field_name' => '_token',
             // an arbitrary string used to generate the value of the token
             // using a different string for each form improves its security
             'csrf_token_id'   => 'enfants_item',
        ]);
    }
}
