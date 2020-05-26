<?php

namespace App\Form;

use App\Entity\Employer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EmployerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom de l\'employé',
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ->add('prenom', TextType::class, [
            'label' => 'Prénom de l\'employé',
            'attr' => [
                'class' => 'form-control'
            ]
        ])
        ->add('photo', FileType::class,
        [
            'label'=>'Image',
            'mapped'=>false, 
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Attention ! Utilisez le bon format',
                ])
            ],
        ])
        ->add('post', ChoiceType::class, [
            'choices' => [
                'Direction' => 'Direction',
                'Informatique' => 'Informatique',
                'Recrutement' => 'Recrutement',
                'Comptabilité' => 'Comptabilité',
                ],
            // 'class' => 'form-control'
        ])
        ->add('save', SubmitType::class, 
        [
            'label'=> 'Valider', 
            'attr'=> [ 'class'=> 'form-control', 'btn btn-warning']
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employer::class,
        ]);
    }
}
