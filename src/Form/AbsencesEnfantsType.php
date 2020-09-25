<?php

namespace App\Form;

use App\Entity\Enfants;
use App\Entity\Absences;
use App\Repository\EnfantsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AbsencesEnfantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    { 
       
        if ($options["data"]->getEnfants()) {
        $IdFamilles = $options["data"]->getEnfants()->getFamilles();
        }else{   
            $IdFamilles = $options["data"]->getUser()->getFamilles();
        }
        $builder
            ->add('enfants', EntityType::class, [
                'class' => Enfants::class,
                'required' => false,
                'query_builder' => function (EnfantsRepository $enfants) use ($IdFamilles) {
                    return $enfants->createQueryBuilder('e')
                        ->where('e.dateDepart IS NULL')
                        ->orWhere('e.dateDepart >= :val')
                        ->andWhere('e.familles = :IdFamilles')
                        ->setParameter('IdFamilles', $IdFamilles)
                        ->setParameter('val', date('Y-m-d'));
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
        ]);
    }
}
