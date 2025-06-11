<?php

namespace App\Controller\Admin;

use App\Entity\Association;
use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class AssociationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Association::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $validRegions = [];
        foreach (Event::getValidRegions() as $region) {
            $validRegions[$region] = $region;
        }

        return [
            TextField::new('titre', 'Titre')->setRequired(true),
            SlugField::new('slug', 'Slug')->setTargetFieldName('titre'),
            TextField::new('numeroJort', 'Numéro du JORT'),
            TextEditorField::new('adresse', 'Adresse')->setRequired(true),
            TextField::new('abreviation', 'Abréviation'),
            TextField::new('lieux', 'Lieux'),
            TextField::new('president', 'Président')->setRequired(true),
            EmailField::new('email', 'Adresse E-mail')->setRequired(true),
            TelephoneField::new('telephone', 'Téléphone')->setRequired(true),
            TelephoneField::new('mobile', 'Mobile'),
            ChoiceField::new('region', 'Régions')
            ->setChoices($validRegions)
            ->setHelp('Sélectionnez les régions concernées'),
            DateField::new('dateFondation', 'Date de fondation'),
            TelephoneField::new('telephone2', 'Téléphone 2')->setRequired(true),
            UrlField::new('facebook', 'Facebook'),
            UrlField::new('twitter', 'Twitter'),
            UrlField::new('youtube', 'Youtube'),
            UrlField::new('google', 'Google'),
            IntegerField::new('anneeFondation', 'Année de fondation')->setRequired(true),
            UrlField::new('siteWeb', 'Site Web'),
            ChoiceField::new('structure', 'Structure')
                ->setChoices([
                    'Association' => 'Association',
                    'Filiale d\'association' => 'Filiale d\'association',
                    'Association internationale' => 'Association internationale',
                    'Club' => 'Club',
                    'Coalitions' => 'Coalitions',
                    'Syndicat' => 'Syndicat'
                ])
                ->setRequired(true),
            AssociationField::new('parent', 'Parent'),
            ChoiceField::new('domaine', 'Domaine')
                ->setChoices([
                    'Agriculture' => 'Agriculture',
                    'Artisanat' => 'Artisanat',
                    'Arts/Culture' => 'Arts/Culture',
                    'Cinéma' => 'Cinéma'
                ])
                ->setRequired(true),
            TextEditorField::new('descriptionPresentation', 'Description et Présentation'),
            DateTimeField::new('lastUpdateDate', 'Dernière mise à jour'),
            ImageField::new('logo', 'Logo')
                ->setBasePath('uploads/logos')
                ->setUploadDir('public/uploads/logos')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextEditorField::new('contactInformation', 'Information de contact'),
            TextEditorField::new('description', 'Description'),
            TextEditorField::new('visAVis', 'Vis-à-vis'),
            TextEditorField::new('coordinates', 'Coordonnées'),
        ];
    }
}