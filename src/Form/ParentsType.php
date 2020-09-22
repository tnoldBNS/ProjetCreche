<?php

namespace App\Form;

use App\Entity\Parents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ParentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Prenom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Email'
                ]
            ])
            ->add('telephone', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Telephone'
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Adresse'
                ]
            ])
            ->add('cp', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Code postale'
                ]
            ])
            ->add('ville', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Ville'
                ]
            ])
            ->add('langueMaternelle', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Langue Maternelle'
                ]
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Selectionner un avatar',
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
            'data_class' => Parents::class,
        ]);
    }
}
