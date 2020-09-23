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
        $IdUser = $options["data"]->getUser();
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
        ]);
    }
}
