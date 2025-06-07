<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessionalExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('position', TextType::class, [
                'label' => 'Position/Job Title',
                'required' => true,
                'attr' => [
                    'placeholder' => 'e.g., Senior Developer, Project Manager'
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'Company/Organization',
                'required' => true,
                'attr' => [
                    'placeholder' => 'e.g., ABC Corporation, XYZ NGO'
                ]
            ])
            ->add('startDate', TextType::class, [
                'label' => 'Start Date',
                'required' => false,
                'attr' => [
                    'placeholder' => 'e.g., 2020, January 2020'
                ]
            ])
            ->add('endDate', TextType::class, [
                'label' => 'End Date',
                'required' => false,
                'attr' => [
                    'placeholder' => 'e.g., 2023, Present, leave empty if current'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => [
                    'rows' => 3,
                    'placeholder' => 'Describe the role, responsibilities, and achievements'
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