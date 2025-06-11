<?php

namespace App\Controller\Admin;

use App\Entity\Organization;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class OrganizationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Organization::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            SlugField::new('slug', 'Slug')
                ->setHelp('The slug is used to build the organization URL'),
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
                ])
                ->setHelp('Brief description about the organization')
                ->setNumOfRows(4),
            EmailField::new('email', 'Email Address'),
            TelephoneField::new('telephone', 'Telephone'),
            TelephoneField::new('mobile', 'Mobile'),
            TextareaField::new('adresse', 'Address')
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
                ->setNumOfRows(3),
            TextareaField::new('contactInformation', 'Contact Information')
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
                ->setNumOfRows(3),
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
                ])
                ->setNumOfRows(3),
            ImageField::new('logo', 'Logo')
                ->setBasePath('uploads/logos')
                ->setUploadDir('public/uploads/logos')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->onlyOnForms(),
            TextField::new('logo', 'Logo File')
                ->onlyOnIndex()
                ->formatValue(function ($value) {
                    return $value ? basename($value) : 'No logo uploaded';
                }),
            CollectionField::new('resources', 'Resources')
                ->onlyOnDetail()
                ->setTemplatePath('admin/field/resources_collection.html.twig'),
        ];
    }
}