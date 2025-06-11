<?php

namespace App\Controller\Admin;

use App\Entity\Actualite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
            TextEditorField::new('resume', 'Résumé')
                ->setHelp('Résumé court de l\'actualité')
                ->setNumOfRows(5),
            TextEditorField::new('contenu', 'Contenu')
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
}