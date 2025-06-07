<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Entity\Organization;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Project Information'),
            TextField::new('title', 'Project Title')
                ->setRequired(true)
                ->setColumns(8),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('title')
                ->setUnlockConfirmationMessage('It is highly recommended to let the slug be automatically generated.')
                ->setHelp('The slug is used to build the project URL')
                ->setColumns(4),
            
            FormField::addRow(),
            DateField::new('dateBegin', 'Start Date')
                ->setRequired(true)
                ->setColumns(6),
            DateField::new('dateEnd', 'End Date')
                ->setRequired(true)
                ->setColumns(6),
            
            ImageField::new('logo', 'Logo')
                ->setBasePath('uploads/projects')
                ->setUploadDir('public/uploads/projects')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setFormType(FileType::class)
                ->setFormTypeOptions([
                    'constraints' => [
                        new File([
                            'maxSize' => '2M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                                'image/webp'
                            ],
                            'mimeTypesMessage' => 'Please upload a valid image file (JPEG, PNG, GIF, WebP)',
                        ])
                    ],
                    'required' => false
                ])
                ->setColumns(12),
            
            FormField::addRow(),
            TextareaField::new('generalObjective', 'General Objective')
                ->setRequired(true)
                ->setColumns(12)
                ->setNumOfRows(4),
            
            TextareaField::new('moreDetails', 'More Details')
                ->setColumns(12)
                ->setNumOfRows(6),
            
            ArrayField::new('specificObjectives', 'Specific Objectives')
                ->setHelp('Add specific objectives for this project')
                ->setColumns(12),
            
            UrlField::new('website', 'Website')
                ->setColumns(12),
            
            ArrayField::new('region', 'Regions')
                ->setHelp('Add regions where this project is active')
                ->setColumns(12),
            
            FormField::addTab('Organizations'),
            AssociationField::new('organizations', 'Partner Organizations')
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true,
                ])
                ->setHelp('Select organizations involved in this project')
                ->setColumns(12)
        ];
    }
}