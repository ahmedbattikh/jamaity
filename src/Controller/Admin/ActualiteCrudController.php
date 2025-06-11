<?php

namespace App\Controller\Admin;

use App\Entity\Actualite;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActualiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Actualite::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre', 'Titre')->setRequired(true),
            TextField::new('slug', 'Slug')
                ->setHelp('URL-friendly version of the title (auto-generated if empty)')
                ->setRequired(false),
            TextareaField::new('resume', 'Résumé')
                ->setFormType(CKEditorType::class)
    
                ->setHelp('Résumé court de l\'actualité'),
            TextareaField::new('contenu', 'Contenu')
                ->setFormType(CKEditorType::class)
                ->setHelp('Contenu complet de l\'actualité')
                ->hideOnIndex(),
            ImageField::new('image', 'Image')
                ->setBasePath('assets/img/')
                ->setUploadDir('public/assets/img/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            DateTimeField::new('datePublication', 'Date de publication')
                ->setFormat('dd/MM/yyyy HH:mm')
                ->setRequired(true),
            TextField::new('auteur', 'Auteur')
                ->setRequired(false),
            ChoiceField::new('statut', 'Statut')
                ->setChoices([
                    'Brouillon' => 'brouillon',
                    'Publié' => 'publie',
                    'Archivé' => 'archive'
                ])
                ->setRequired(true),
            ArrayField::new('tags', 'Tags')
                ->setHelp('Mots-clés séparés par des virgules')
                ->hideOnIndex(),
            BooleanField::new('featured', 'À la une')
                ->setHelp('Mettre cette actualité en avant')
        ];
    }
    
    public function configureCrud(Crud $crud): Crud

 {

   return $crud

       ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');

 }
}