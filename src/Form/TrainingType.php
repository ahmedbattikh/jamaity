<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('degree', TextType::class, [
                'label' => 'Degree/Certification',
                'required' => true,
                'attr' => [
                    'placeholder' => 'e.g., Master en Sciences, Certification PMP'
                ]
            ])
            ->add('institution', TextType::class, [
                'label' => 'Institution/Organization',
                'required' => true,
                'attr' => [
                    'placeholder' => 'e.g., Université de Tunis, Coursera'
                ]
            ])
            ->add('year', TextType::class, [
                'label' => 'Year',
                'required' => false,
                'attr' => [
                    'placeholder' => 'e.g., 2020, 2018-2020'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'rows' => 3,
                    'placeholder' => 'Additional details about the training or certification'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}