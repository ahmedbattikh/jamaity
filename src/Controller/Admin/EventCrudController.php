<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
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
            TextareaField::new('description', 'Description')
                ->setFormType(CKEditorType::class),
            DateTimeField::new('dateDebut', 'Date de début'),
            DateTimeField::new('dateFin', 'Date de fin'),
            TextField::new('lieu', 'Lieu'),
            TextareaField::new('detailEvenement', 'Détail événement'),
            ImageField::new('image', 'Image')
                ->setBasePath('uploads/events')
                ->setUploadDir('public/uploads/events'),
            ChoiceField::new('statut', 'Statut')
                ->setChoices([
                    'Planifié' => 'planifie',
                    'En cours' => 'en_cours',
                    'Terminé' => 'termine',
                    'Annulé' => 'annule'
                ]),
            ChoiceField::new('region', 'Régions')
                ->setChoices($validRegions)
                ->allowMultipleChoices()
                ->setHelp('Sélectionnez les régions concernées'),
            AssociationField::new('organizations', 'Organisations')
                ->setFormTypeOptions([
                    'multiple' => true,
                    'by_reference' => false,
                ])
                ->setHelp('Sélectionnez les organisations participantes à cet événement'),
        ];
    }
    public function configureCrud(Crud $crud): Crud

    {
   
      return $crud
   
          ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
   
    }
}