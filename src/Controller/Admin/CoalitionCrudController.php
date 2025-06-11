<?php

namespace App\Controller\Admin;

use App\Entity\Coalition;
use App\Entity\Event;
use App\Enum\ThemeEnum;
use App\Enum\AssociationTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class CoalitionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Coalition::class;
    }

    public function configureFields(string $pageName): iterable
    {   $validRegions = [];
        foreach (Event::getValidRegions() as $region) {
            $validRegions[$region] = $region;
        }

        return [
            TextField::new('titre', 'Titre')->setRequired(true),
            SlugField::new('slug', 'Slug')->setTargetFieldName('titre'),
            TextEditorField::new('adresse', 'Adresse'),
            TextField::new('abreviation', 'Abréviation'),
            TextField::new('lieux', 'Lieux'),
            TextField::new('president', 'Président'),
            EmailField::new('email', 'Adresse E-mail'),
            TelephoneField::new('telephone', 'Téléphone'),
            TelephoneField::new('mobile', 'Mobile'),
            ChoiceField::new('region', 'Régions')
            ->setChoices($validRegions)
            ->setHelp('Sélectionnez les régions concernées'),
            DateField::new('dateFondation', 'Date de fondation'),
            UrlField::new('facebook', 'Facebook'),
            UrlField::new('twitter', 'Twitter'),
            UrlField::new('youtube', 'Youtube'),
            UrlField::new('siteWeb', 'Site Web'),
            ChoiceField::new('domaine', 'Domaine')
                ->setChoices(ThemeEnum::getChoices()),
            ChoiceField::new('structure', 'Structure')
                ->setChoices(AssociationTypeEnum::getChoices()),
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