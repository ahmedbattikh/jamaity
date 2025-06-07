<?php

namespace App\Controller\Admin;

use App\Entity\Coalition;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class CoalitionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Coalition::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre', 'Titre')->setRequired(true),
            SlugField::new('slug', 'Slug')->setTargetFieldName('titre'),
            TextareaField::new('adresse', 'Adresse'),
            TextField::new('abreviation', 'Abréviation'),
            TextField::new('lieux', 'Lieux'),
            TextField::new('president', 'Président'),
            EmailField::new('email', 'Adresse E-mail'),
            TelephoneField::new('telephone', 'Téléphone'),
            TelephoneField::new('mobile', 'Mobile'),
            TextField::new('region', 'Région'),
            DateField::new('dateFondation', 'Date de fondation'),
            UrlField::new('facebook', 'Facebook'),
            UrlField::new('twitter', 'Twitter'),
            UrlField::new('youtube', 'Youtube'),
            UrlField::new('siteWeb', 'Site Web'),
            ChoiceField::new('domaine', 'Domaine')
                ->setChoices([
                    'Agriculture' => 'Agriculture',
                    'Artisanat' => 'Artisanat',
                    'Arts/Culture' => 'Arts/Culture',
                    'Cinéma' => 'Cinéma',
                    'Environnement' => 'Environnement',
                    'Éducation' => 'Éducation',
                    'Santé' => 'Santé',
                    'Droits humains' => 'Droits humains'
                ]),
            ChoiceField::new('structure', 'Structure')
                ->setChoices([
                    'Association' => 'Association',
                    'Filiale d\'association' => 'Filiale d\'association',
                    'Association internationale' => 'Association internationale',
                    'Club' => 'Club',
                    'Coalitions' => 'Coalitions',
                    'Syndicat' => 'Syndicat'
                ]),
            DateTimeField::new('lastUpdateDate', 'Dernière mise à jour'),
            ImageField::new('logo', 'Logo')
                ->setBasePath('uploads/logos')
                ->setUploadDir('public/uploads/logos')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextareaField::new('contactInformation', 'Information de contact'),
            TextareaField::new('description', 'Description'),
            TextareaField::new('visAVis', 'Vis-à-vis'),
            TextareaField::new('coordinates', 'Coordonnées'),
        ];
    }
}