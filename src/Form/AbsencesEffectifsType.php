<?php

namespace App\Form;

use App\Entity\Absences;
use App\Entity\Effectifs;
use App\Repository\EffectifsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AbsencesEffectifsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options["data"]->getEffectifs()) {
            $IdUser = $options["data"]->getEffectifs()->getUsers();
        } else {
            $IdUser = $options["data"]->getUser();
        }
        $builder
            ->add('effectifs', EntityType::class, [
                'class' => Effectifs::class,
                'required' => false,
                'query_builder' => function (EffectifsRepository $effectifs) use ($IdUser) {
                    return $effectifs->createQueryBuilder('e')
                        ->where('e.Users = :IdUser')
                        ->setParameter('IdUser', $IdUser);
                },
                'placeholder' => 'Choisir un membre du personnel',
                'attr' => [
                    'class' => 'uk-input',
                ]
            ])

            ->add('motif', ChoiceType::class, [
                'choices' => [
                    'A selectionner' => "",
                    'Maladie' => 'Maladie',
                    'Vacances' => 'Vacances',
                    'Autre' => 'Autre',
                ],
                'label' => 'Selectionner un motif',
                'attr' => [
                    'class' => 'uk-input',
                ]
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'label' => "Date de début",
                'attr' => [
                    'class' => 'uk-input',
                ]
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'label' => "Date de Fin",
                'attr' => [
                    'class' => 'uk-input',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Absences::class,
             // enable/disable CSRF protection for this form
             'csrf_protection' => true,
             // the name of the hidden HTML field that stores the token
             'csrf_field_name' => '_token',
             // an arbitrary string used to generate the value of the token
             // using a different string for each form improves its security
             'csrf_token_id'   => 'absencesEffectifs_item',
        ]);
    }
}
