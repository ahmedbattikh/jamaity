<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Controller\Admin\OrganizationCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $validRegions = [
            'Tunis' => 'Tunis',
            'Ariana' => 'Ariana',
            'Ben Arous' => 'Ben Arous',
            'Manouba' => 'Manouba',
            'Nabeul' => 'Nabeul',
            'Zaghouan' => 'Zaghouan',
            'Bizerte' => 'Bizerte',
            'Béja' => 'Béja',
            'Jendouba' => 'Jendouba',
            'Kef' => 'Kef',
            'Siliana' => 'Siliana',
            'Kairouan' => 'Kairouan',
            'Kasserine' => 'Kasserine',
            'Sidi Bouzid' => 'Sidi Bouzid',
            'Sousse' => 'Sousse',
            'Monastir' => 'Monastir',
            'Mahdia' => 'Mahdia',
            'Sfax' => 'Sfax',
            'Gafsa' => 'Gafsa',
            'Tozeur' => 'Tozeur',
            'Kebili' => 'Kebili',
            'Gabès' => 'Gabès',
            'Medenine' => 'Medenine',
            'Tataouine' => 'Tataouine'
        ];

        return [
            FormField::addTab('Basic Information'),
            IdField::new('id')
                ->hideOnForm(),
            
            TextField::new('title', 'Project Title')
                ->setRequired(true)
                ->setColumns(6)
                ->setHelp('Enter the project title'),
            
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('title')
                ->setColumns(6)
                ->setHelp('URL-friendly version of the title'),
            
            DateField::new('dateBegin', 'Start Date')
                ->setRequired(true)
                ->setColumns(6),
            
            DateField::new('dateEnd', 'End Date')
                ->setRequired(true)
                ->setColumns(6),
            
            UrlField::new('website', 'Website')
                ->setColumns(6)
                ->setHelp('Project website URL'),
            
            ChoiceField::new('region', 'Regions')
                ->setChoices($validRegions)
                ->allowMultipleChoices()
                ->setColumns(6)
                ->setHelp('Select the regions where this project operates'),
            
            FormField::addRow(),
            
            TextEditorField::new('generalObjective', 'General Objective')
                ->setRequired(true)
                ->setColumns(12)
                ->setNumOfRows(4)
                ->setHelp('Describe the main objective of the project'),
            
            TextEditorField::new('moreDetails', 'More Details')
                ->setColumns(12)
                ->setNumOfRows(4)
                ->setHelp('Additional details about the project'),
            
            ArrayField::new('specificObjectives', 'Specific Objectives')
                ->setColumns(12)
                ->setHelp('List specific objectives, one per line'),
            
            FormField::addTab('Media & Organizations'),
            
            ImageField::new('logo', 'Project Logo')
                ->setBasePath('uploads/projects')
                ->setUploadDir('public/uploads/projects')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setHelp('Upload project logo (JPG, PNG, or GIF)')
                ->onlyOnForms(),
            
            TextField::new('logo', 'Logo File')
                ->onlyOnIndex()
                ->formatValue(function ($value) {
                    return $value ? basename($value) : 'No logo uploaded';
                }),
            
            AssociationField::new('organizations', 'Partner Organizations')
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true,
                ])
                ->autocomplete()
                ->setCrudController(OrganizationCrudController::class)
                ->setHelp('Select organizations involved in this project')
                ->setColumns(12)
        ];
    }
}