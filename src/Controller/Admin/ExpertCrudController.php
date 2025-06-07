<?php

namespace App\Controller\Admin;

use App\Entity\Expert;
use App\Entity\Organization;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use Symfony\Component\Validator\Constraints\File;

class ExpertCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Expert::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Personal Information'),
            TextField::new('firstName', 'First Name')
                ->setRequired(true)
                ->setColumns(6),
            TextField::new('lastName', 'Last Name')
                ->setRequired(true)
                ->setColumns(6),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('firstName')
                ->setUnlockConfirmationMessage('It is highly recommended to let the slug be automatically generated.')
                ->setHelp('The slug is used to build the expert URL'),
            EmailField::new('email', 'Email Address')
                ->setRequired(true)
                ->setColumns(6),
            TelephoneField::new('phoneNumber', 'Phone Number')
                ->setRequired(true)
                ->setColumns(6),
            UrlField::new('linkedin', 'LinkedIn Profile')
                ->setHelp('Full LinkedIn profile URL'),
            DateField::new('birthday', 'Birthday'),
            ChoiceField::new('gender', 'Gender')
                ->setChoices([
                    'Male' => 'male',
                    'Female' => 'female',
                    'Other' => 'other',
                    'Prefer not to say' => 'not_specified'
                ])
                ->allowMultipleChoices(false)
                ->renderExpanded(false),
            TextareaField::new('description', 'Description')
                ->setHelp('Brief description about the expert')
                ->setNumOfRows(4),
            TextField::new('areaOfExpertise', 'Area of Expertise')
                ->setHelp('Main area of expertise or specialization'),
            TextField::new('region', 'Region')
                ->setHelp('Geographic region or location'),
            
            FormField::addTab('Professional Information'),
            ImageField::new('resume', 'Resume')
                ->setBasePath('uploads/experts')
                ->setUploadDir('public/uploads/experts')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setFileConstraints(new File([
                    'mimeTypes' => [
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'image/jpeg',
                        'image/png',
                        'image/jpg'
                    ],
                    'mimeTypesMessage' => 'Please upload a valid file (PDF, Word document, or image)',
                ]))
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => '.pdf,.doc,.docx,.jpg,.jpeg,.png'
                    ],
                    'help' => 'Upload resume file (PDF, Word document, or image)'
                ])
                ->onlyOnForms(),
            TextField::new('resume', 'Resume File')
                ->onlyOnIndex()
                ->formatValue(function ($value) {
                    return $value ? basename($value) : 'No file uploaded';
                }),
            ImageField::new('picture', 'Profile Picture')
                ->setBasePath('uploads/experts')
                ->setUploadDir('public/uploads/experts')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => '.jpg,.jpeg,.png,.gif'
                    ],
                    'help' => 'Upload profile picture (JPG, PNG, or GIF)'
                ])
                ->onlyOnForms(),
            TextField::new('picture', 'Picture File')
                ->onlyOnIndex()
                ->formatValue(function ($value) {
                    return $value ? basename($value) : 'No file uploaded';
                }),
            
            CollectionField::new('professionalExperience', 'Professional Experience')
                ->setEntryType(\App\Form\ProfessionalExperienceType::class)
                ->allowAdd()
                ->allowDelete()
                ->setHelp('Add professional experience entries')
                ->hideOnIndex(),
            
            CollectionField::new('training', 'Training & Certifications')
                ->setEntryType(\App\Form\TrainingType::class)
                ->allowAdd()
                ->allowDelete()
                ->setHelp('Add training and certification entries')
                ->hideOnIndex(),
            
            FormField::addTab('Organizations'),
            AssociationField::new('workedWith', 'Organizations Worked With')
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true,
                ])
                ->autocomplete()
                ->setCrudController(OrganizationCrudController::class)
                ->setHelp('Select organizations this expert has worked with'),
        ];
    }
}