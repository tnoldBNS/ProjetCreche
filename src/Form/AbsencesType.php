<?php

namespace App\Form;

use App\Entity\Enfants;
use App\Entity\Absences;
use App\Entity\Effectifs;
use App\Repository\EnfantsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AbsencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('effectifs', EntityType::class, [
                'class' => Effectifs::class,
                'required' => false,
                'placeholder' => 'Choisir un membre du personnel',
                'attr' => [
                    'class' => 'uk-input',
                ]
            ])
            ->add('enfants', EntityType::class, [
                'class' => Enfants::class,
                'required' => false,
                'query_builder' => function (EnfantsRepository $enfants) {
                    return $enfants->createQueryBuilder('e')
                        ->where('e.dateDepart IS NULL')
                        ->orWhere('e.dateDepart >= :val')
                        ->setParameter('val', date('Y-m-d'));
                        ;
                },
                'placeholder' => 'Choisir un Enfant',
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
             'csrf_token_id'   => 'absences_item',
        ]);
    }
}
