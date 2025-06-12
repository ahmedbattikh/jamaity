<?php

namespace App\Controller\Admin;

use App\Entity\Resource;
use App\Enum\ResourceTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use App\Field\MultipleFileField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class ResourceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Resource::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Resource')
            ->setEntityLabelInPlural('Resources')
            ->setSearchFields(['name', 'slug', 'type', 'description'])
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('type')
                ->setChoices(ResourceTypeEnum::getChoices())
            );
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')
                ->setRequired(true)
                ->setHelp('The display name of the resource'),
            TextField::new('slug')
                ->setRequired(true)
                ->setHelp('Unique identifier for the resource (URL-friendly)'),
            ChoiceField::new('type')
                ->setChoices(ResourceTypeEnum::getChoices())
                ->setRequired(true),
            ImageField::new('previewImg')
                ->setBasePath('uploads/resources/previews')
                ->setUploadDir('public/uploads/resources/previews')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setHelp('Preview image for the resource (optional)'),
            ImageField::new('document')
                ->setBasePath('uploads/resources')
                ->setUploadDir('public/uploads/resources')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setHelp('Main document/file for this resource'),
            TextareaField::new('description')
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
                ])
                ->setNumOfRows(4)
                ->setHelp('Description of the resource'),
            MultipleFileField::new('files')
                ->setUploadDir('public/uploads/resources')
                ->setBasePath('uploads/resources')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setHelp('Upload multiple files (PDF, DOC, XLS, images, etc.)'),
            DateTimeField::new('createdAt')
                ->hideOnForm()
                ->setFormat('dd/MM/yyyy HH:mm'),
            DateTimeField::new('updatedAt')
                ->hideOnForm()
                ->setFormat('dd/MM/yyyy HH:mm'),
        ];
    }

    public function persistEntity($entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Resource) {
            $entityInstance->setCreatedAt(new \DateTime());
            $entityInstance->setUpdatedAt(new \DateTime());
        }
        
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity($entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Resource) {
            $entityInstance->setUpdatedAt(new \DateTime());
        }
        
        parent::updateEntity($entityManager, $entityInstance);
    }
}