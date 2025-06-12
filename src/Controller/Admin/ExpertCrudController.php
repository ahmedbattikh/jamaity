<?php

namespace App\Controller\Admin;

use App\Entity\Expert;
use App\Entity\Organization;
use App\Enum\ExpertiseEnum;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ExpertCrudController extends AbstractCrudController
{
    public function __construct(
        private SluggerInterface $slugger
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Expert::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Personal Information'),
            TextField::new('firstName', 'First Name')
                ->setRequired(true)
                ->setColumns(6),
            TextField::new('lastName', 'Last Name')
                ->setRequired(true)
                ->setColumns(6),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('firstName')
                ->setUnlockConfirmationMessage('It is highly recommended to let the slug be automatically generated.')
                ->setHelp('The slug is used to build the expert URL'),
            EmailField::new('email', 'Email Address')
                ->setRequired(true)
                ->setColumns(6),
            TelephoneField::new('phoneNumber', 'Phone Number')
                ->setRequired(true)
                ->setColumns(6),
            UrlField::new('linkedin', 'LinkedIn Profile')
                ->setHelp('Full LinkedIn profile URL'),
            DateField::new('birthday', 'Birthday'),
            ChoiceField::new('gender', 'Gender')
                ->setChoices([
                    'Male' => 'male',
                    'Female' => 'female',
                    'Other' => 'other',
                    'Prefer not to say' => 'not_specified'
                ])
                ->allowMultipleChoices(false)
                ->renderExpanded(false),
            TextareaField::new('description', 'Description')
                ->setFormType(CKEditorType::class)
                ->setHelp('Brief description about the expert')
                ->setNumOfRows(4),
            ChoiceField::new('areaOfExpertise', 'Area of Expertise')
                ->setChoices(ExpertiseEnum::getChoices())
                ->setHelp('Main area of expertise or specialization'),
            TextField::new('region', 'Region')
                ->setHelp('Geographic region or location'),
            
            FormField::addTab('Professional Information'),
            Field::new('resume', 'Resume')
                ->setFormType(\Symfony\Component\Form\Extension\Core\Type\FileType::class)
                ->setFormTypeOptions([
                    'attr' => ['accept' => '.pdf,.doc,.docx'],
                    'required' => false,
                    'mapped' => false
                ])
                ->setHelp('Upload resume file (PDF, DOC, or DOCX)')
                ->onlyOnForms(),
            TextField::new('resume', 'Resume File')
                ->onlyOnIndex()
                ->formatValue(function ($value) {
                    return $value ? basename($value) : 'No file uploaded';
                }),
            ImageField::new('picture', 'Profile Picture')
                ->setBasePath('uploads/experts')
                ->setUploadDir('public/uploads/experts')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setHelp('Upload profile picture (JPG, PNG, or GIF)')
                ->onlyOnForms(),
            TextField::new('picture', 'Picture File')
                ->onlyOnIndex()
                ->formatValue(function ($value) {
                    return $value ? basename($value) : 'No file uploaded';
                }),
            
            CollectionField::new('professionalExperience', 'Professional Experience')
                ->setEntryType(\App\Form\ProfessionalExperienceType::class)
                ->allowAdd()
                ->allowDelete()
                ->setHelp('Add professional experience entries')
                ->hideOnIndex(),
            
            CollectionField::new('training', 'Training & Certifications')
                ->setEntryType(\App\Form\TrainingType::class)
                ->allowAdd()
                ->allowDelete()
                ->setHelp('Add training and certification entries')
                ->hideOnIndex(),
            
            FormField::addTab('Organizations'),
            AssociationField::new('workedWith', 'Organizations Worked With')
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'multiple' => true,
                ])
                ->autocomplete()
                ->setCrudController(OrganizationCrudController::class)
                ->setHelp('Select organizations this expert has worked with'),
        ];
    }

    public function persistEntity($entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Expert) {
            $this->handleResumeUpload($entityInstance);
        }
        
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity($entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Expert) {
            $this->handleResumeUpload($entityInstance);
        }
        
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function handleResumeUpload(Expert $expert): void
    {
        $request = $this->getContext()->getRequest();
        $resumeFile = $request->files->get('Expert')['resume'] ?? null;
        
        if ($resumeFile instanceof UploadedFile) {
            $originalFilename = pathinfo($resumeFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename . '-' . uniqid() . '.' . $resumeFile->guessExtension();
            
            $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/experts';
            
            // Create directory if it doesn't exist
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }
            
            try {
                $resumeFile->move($uploadDirectory, $fileName);
                $expert->setResume($fileName);
            } catch (\Exception $e) {
                // Handle upload error - could log or throw exception
            }
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }
}