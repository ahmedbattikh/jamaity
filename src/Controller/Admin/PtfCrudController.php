<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Ptf;
use App\Enum\ThemeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
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

class PtfCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ptf::class;
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
            AssociationField::new('parent', 'Parent'),
            ChoiceField::new('domaine', 'Domaine')
                ->setChoices(ThemeEnum::getChoices())
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
            // PTF-specific fields
            IntegerField::new('annee', 'Année'),
            TextEditorField::new('mission', 'Mission'),
            TelephoneField::new('telephone1', 'Téléphone 1'),
            UrlField::new('linkedin', 'LinkedIn'),
            TextEditorField::new('prioritesStrategiques', 'Priorités stratégiques du bailleur'),
            ChoiceField::new('missionThemePrioritaire', 'Une mission / thème prioritaire')
                ->setChoices(ThemeEnum::getChoices())
                ->setHelp('Sélectionnez le thème prioritaire'),
            TextField::new('nomContact', 'Nom du Contact'),
            TextField::new('poste', 'Poste'),
            TelephoneField::new('numeroTelephoneContact', 'Numéro de Téléphone (Contact)'),
            TelephoneField::new('fax', 'Fax'),
            ArrayField::new('priorites', 'Priorités')
                ->setHelp('Ajoutez les priorités une par ligne'),
            ArrayField::new('particularites', 'Particularités')
                ->setHelp('Ajoutez les particularités une par ligne'),
            ArrayField::new('mecanisme', 'Mécanisme')
                ->setHelp('Ajoutez les mécanismes un par ligne'),
        ];
    }
}