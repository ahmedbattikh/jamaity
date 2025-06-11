<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Ptf;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
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
            IntegerField::new('annee', 'Année'),
            TextEditorField::new('adresse', 'Adresse'),
            TextField::new('abreviation', 'Abréviation'),
            TextField::new('lieux', 'Lieux'),
            TextEditorField::new('mission', 'Mission'),
            EmailField::new('email', 'Adresse E-mail'),
            TelephoneField::new('telephone', 'Téléphone'),
            TelephoneField::new('mobile', 'Mobile'),
            TelephoneField::new('telephone1', 'Téléphone 1'),
            ChoiceField::new('region', 'Régions')
            ->setChoices($validRegions)
            ->setHelp('Sélectionnez les régions concernées'),
            DateField::new('dateFondation', 'Date de fondation'),
            UrlField::new('facebook', 'Facebook'),
            UrlField::new('twitter', 'Twitter'),
            UrlField::new('youtube', 'Youtube'),
            UrlField::new('linkedin', 'LinkedIn'),
            UrlField::new('siteWeb', 'Site Web'),
            TextEditorField::new('prioritesStrategiques', 'Priorités stratégiques du bailleur'),
            TextEditorField::new('missionThemePrioritaire', 'Une mission / thème prioritaire'),
            TextField::new('nomContact', 'Nom du Contact'),
            TextField::new('poste', 'Poste'),
            TelephoneField::new('numeroTelephoneContact', 'Numéro de Téléphone (Contact)'),
            TelephoneField::new('fax', 'Fax'),
            ChoiceField::new('domaine', 'Domaine')
                ->setChoices([
                    'Agriculture' => 'Agriculture',
                    'Artisanat' => 'Artisanat',
                    'Arts/Culture' => 'Arts/Culture',
                    'Cinéma' => 'Cinéma',
                    'Environnement' => 'Environnement',
                    'Éducation' => 'Éducation',
                    'Santé' => 'Santé',
                    'Droits humains' => 'Droits humains',
                    'Développement économique' => 'Développement économique'
                ]),
            ImageField::new('logo', 'Logo')
                ->setBasePath('uploads/logos')
                ->setUploadDir('public/uploads/logos')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextEditorField::new('description', 'Description'),
            ArrayField::new('priorites', 'Priorités')
                ->setHelp('Ajoutez les priorités une par ligne'),
            ArrayField::new('particularites', 'Particularités')
                ->setHelp('Ajoutez les particularités une par ligne'),
            ArrayField::new('mecanisme', 'Mécanisme')
                ->setHelp('Ajoutez les mécanismes un par ligne'),
            TextEditorField::new('contactInformation', 'Information de contact'),
            TextEditorField::new('visAVis', 'Vis-à-vis'),
            TextEditorField::new('coordinates', 'Coordonnées'),
        ];
    }
}