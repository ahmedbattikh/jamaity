<?php

namespace App\Controller\Admin;

use App\Entity\Organization;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
                ->setHelp('Brief description about the organization')
                ->setNumOfRows(4),
            EmailField::new('email', 'Email Address'),
            TelephoneField::new('telephone', 'Telephone'),
            TelephoneField::new('mobile', 'Mobile'),
            TextareaField::new('adresse', 'Address')
                ->setNumOfRows(3),
            TextareaField::new('contactInformation', 'Contact Information')
                ->setNumOfRows(3),
            TextareaField::new('visAVis', 'Vis-à-vis')
                ->setNumOfRows(3),
            Field::new('logo', 'Logo')
                ->setFormType(FileType::class)
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => '.jpg,.jpeg,.png,.gif'
                    ],
                    'help' => 'Upload logo (JPG, PNG, or GIF)'
                ])
                ->onlyOnForms(),
            TextField::new('logo', 'Logo File')
                ->onlyOnIndex()
                ->formatValue(function ($value) {
                    return $value ? basename($value) : 'No logo uploaded';
                }),
        ];
    }
}