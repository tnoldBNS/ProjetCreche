<?php

namespace App\Form;

use App\Entity\Enfants;
use App\Entity\Galleries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class GalleriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Titre'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Description'
                ]
            ])
            ->add('enfants', EntityType::class, [
                'class' => Enfants::class,
                'multiple' => true,
                'label' => 'Selectionnez les enfants visible sur la photo [CRTL + click]',
                'attr' => [
                    'class' => 'uk-select',
                ]
            ])
            ->add('albumPrive', ChoiceType::class, [
                'choices' => [
                    'Oui' => false,
                    'Non' => true,
                ],
                'label' => 'Accessible aux parents ? ',
                'attr' => [
                    'class' => 'uk-input',
                ]
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Selectionner une Photo',
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
            'data_class' => Galleries::class,
        ]);
    }
}
