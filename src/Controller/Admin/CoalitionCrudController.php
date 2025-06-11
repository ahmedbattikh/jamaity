<?php

namespace App\Controller\Admin;

use App\Entity\Coalition;
use App\Entity\Event;
use App\Enum\ThemeEnum;
use App\Enum\AssociationTypeEnum;
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
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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
            TextField::new('numeroJort', 'Numéro du JORT'),
            TextareaField::new('adresse', 'Adresse')
                ->setFormType(CKEditorType::class)
                ->setFormTypeOptions([
                    'config' => [
                        'toolbar' => [
                            ['Bold', 'Italic', 'Underline', 'Strike'],
                            ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'],
                            ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                            ['Link', 'Unlink'],
                            ['RemoveFormat', 'Source']
                        ],
                        'height' => 200,
                        'uiColor' => '#ffffff',
                        'removePlugins' => 'elementspath',
                        'resize_enabled' => false
                    ]
                ])
                ->setRequired(true),
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
                ->setChoices(AssociationTypeEnum::getChoices())
                ->setRequired(true),
            AssociationField::new('parent', 'Parent'),
            ChoiceField::new('domaine', 'Domaine')
                ->setChoices(ThemeEnum::getChoices())
                ->setRequired(true),
            TextareaField::new('descriptionPresentation', 'Description et Présentation')
                ->setFormType(CKEditorType::class)
                ->setFormTypeOptions([
                    'config' => [
                        'toolbar' => [
                            ['Bold', 'Italic', 'Underline', 'Strike'],
                            ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'],
                            ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                            ['Link', 'Unlink'],
                            ['Image', 'Table'],
                            ['RemoveFormat', 'Source']
                        ],
                        'height' => 400,
                        'uiColor' => '#ffffff',
                        'removePlugins' => 'elementspath',
                        'resize_enabled' => false
                    ]
                ]),
            DateTimeField::new('lastUpdateDate', 'Dernière mise à jour'),
            ImageField::new('logo', 'Logo')
                ->setBasePath('uploads/logos')
                ->setUploadDir('public/uploads/logos')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextareaField::new('contactInformation', 'Information de contact')
                ->setFormType(CKEditorType::class)
                ->setFormTypeOptions([
                    'config' => [
                        'toolbar' => [
                            ['Bold', 'Italic', 'Underline', 'Strike'],
                            ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'],
                            ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                            ['Link', 'Unlink'],
                            ['RemoveFormat', 'Source']
                        ],
                        'height' => 200,
                        'uiColor' => '#ffffff',
                        'removePlugins' => 'elementspath',
                        'resize_enabled' => false
                    ]
                ]),
            TextareaField::new('description', 'Description')
                ->setFormType(CKEditorType::class)
                ->setFormTypeOptions([
                    'config' => [
                        'toolbar' => [
                            ['Bold', 'Italic', 'Underline', 'Strike'],
                            ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'],
                            ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                            ['Link', 'Unlink'],
                            ['RemoveFormat', 'Source']
                        ],
                        'height' => 300,
                        'uiColor' => '#ffffff',
                        'removePlugins' => 'elementspath',
                        'resize_enabled' => false
                    ]
                ]),
            TextareaField::new('visAVis', 'Vis-à-vis')
                ->setFormType(CKEditorType::class)
                ->setFormTypeOptions([
                    'config' => [
                        'toolbar' => [
                            ['Bold', 'Italic', 'Underline', 'Strike'],
                            ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'],
                            ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                            ['Link', 'Unlink'],
                            ['RemoveFormat', 'Source']
                        ],
                        'height' => 200,
                        'uiColor' => '#ffffff',
                        'removePlugins' => 'elementspath',
                        'resize_enabled' => false
                    ]
                ]),
            TextareaField::new('coordinates', 'Coordonnées')
                ->setFormType(CKEditorType::class)
                ->setFormTypeOptions([
                    'config' => [
                        'toolbar' => [
                            ['Bold', 'Italic', 'Underline', 'Strike'],
                            ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'],
                            ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                            ['Link', 'Unlink'],
                            ['RemoveFormat', 'Source']
                        ],
                        'height' => 200,
                        'uiColor' => '#ffffff',
                        'removePlugins' => 'elementspath',
                        'resize_enabled' => false
                    ]
                ]),
        ];
    }
}