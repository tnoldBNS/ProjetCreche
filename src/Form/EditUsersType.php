<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('roles', ChoiceType::class, [
            'choices' => [
                'Utilisateur (par defaut)' => 'ROLE_USER',
                'Administrateur' => 'ROLE_ADMIN',
                'Famille' => 'ROLE_FAMILLE',
                'Effectif' => 'ROLE_EFFECTIF',
                'Accueil' => 'ROLE_ACCUEIL'				
            ],
    
            'multiple' => true,
            'label' => 'Rôles',
            'attr' => [
                'class' => 'uk-select',
            ]
        ])
            ->add('nom', TextType::class, [
                'label' => false,
                'attr' => [
                'class' => 'uk-input',
                'placeholder' => 'Nom']
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                'class' => 'uk-input',
                'placeholder' => 'Email']
            ])
            ->add('telephone', TextType::class, [
                'label' => false,
                'attr' => [
                'class' => 'uk-input',
                'placeholder' => 'Telephone']
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => false,
                'type' => PasswordType::class,
                'required' => false,
                'invalid_message' => 'Le mot de passe ne correspond pas',
                'first_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'uk-input',
                        'placeholder' => 'Mot de passe']
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'uk-input',
                    'placeholder' => 'Répétez le mot de passe']
                ]
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'uk-button uk-button-primary uk-margin-top']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
