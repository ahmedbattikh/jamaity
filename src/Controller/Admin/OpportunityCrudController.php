<?php

namespace App\Controller\Admin;

use App\Entity\Opportunity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class OpportunityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Opportunity::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Get valid choices from entity static methods
        $validOpportunityTypes = [];
        foreach (Opportunity::getValidOpportunityTypes() as $type) {
            $validOpportunityTypes[ucfirst(str_replace('_', ' ', $type))] = $type;
        }
        
        $validRegions = [];
        foreach (Opportunity::getValidRegions() as $region) {
            $validRegions[$region] = $region;
        }

        return [
            TextField::new('titre', 'Titre')
                ->setRequired(true)
                ->setColumns(6),
            
            TextField::new('slug', 'Slug')
                ->setHelp('URL-friendly version du titre (généré automatiquement si vide)')
                ->setColumns(6),
            
            AssociationField::new('organizationRelated', 'Organisation liée')
                ->setColumns(6)
                ->setHelp('Sélectionnez l\'organisation responsable de cette opportunité'),
            
            TextEditorField::new('opportunityDetails', 'Détails de l\'opportunité')
                ->setNumOfRows(4)
                ->setColumns(12),
            
            ArrayField::new('eligibilityCriteria', 'Critères d\'éligibilité')
                ->setHelp('Ajoutez les critères d\'éligibilité un par ligne')
                ->setColumns(6),
            
            TextEditorField::new('howToApply', 'Comment postuler')
                ->setNumOfRows(3)
                ->setColumns(6),
            
            DateField::new('dueDate', 'Date limite')
                ->setRequired(true)
                ->setColumns(4),
            
            ChoiceField::new('typeOfOpportunities', 'Type d\'opportunités')
                ->setChoices($validOpportunityTypes)
                ->setRequired(true)
                ->setColumns(4),
            
            ChoiceField::new('statut', 'Statut')
                ->setChoices([
                    'Active' => 'active',
                    'Fermée' => 'fermee',
                    'Brouillon' => 'brouillon',
                    'Archivée' => 'archivee'
                ])
                ->setRequired(true)
                ->setColumns(4),
            
            ChoiceField::new('regions', 'Régions')
                ->setChoices($validRegions)
                ->allowMultipleChoices()
                ->setHelp('Sélectionnez les régions concernées')
                ->setColumns(6),
            
            ArrayField::new('interventionThemes', 'Thèmes d\'intervention')
                ->setHelp('Ajoutez les thèmes d\'intervention un par ligne')
                ->setColumns(6),
            
            TextField::new('organisme', 'Organisme')
                ->setColumns(6),
            
            ImageField::new('logo', 'Logo')
                ->setBasePath('/uploads/logos')
                ->setUploadDir('public/uploads/logos')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->setColumns(6)
                ->setHelp('Téléchargez le logo de l\'opportunité'),
            
            TextEditorField::new('budget', 'Budget')
                ->setNumOfRows(2)
                ->setColumns(6)
                ->setHelp('Décrivez le budget disponible ou les montants'),
            
            EmailField::new('contactEmail', 'Email de contact')
                ->setColumns(4),
            
            TelephoneField::new('contactTelephone', 'Téléphone de contact')
                ->setColumns(4),
            
            UrlField::new('siteWeb', 'Site Web')
                ->setColumns(4),
            
            DateTimeField::new('dateCreation', 'Date de création')
                ->setFormTypeOptions(['disabled' => true])
                ->hideOnForm()
                ->setColumns(6),
            
            DateTimeField::new('dateModification', 'Date de modification')
                ->setFormTypeOptions(['disabled' => true])
                ->hideOnForm()
                ->setColumns(6),
        ];
    }
}