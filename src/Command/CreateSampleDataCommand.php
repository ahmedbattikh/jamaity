<?php

namespace App\Command;

use App\Entity\Association;
use App\Entity\Coalition;
use App\Entity\Event;
use App\Entity\Opportunity;
use App\Entity\Project;
use App\Entity\Ptf;
use App\Enum\OpportunityTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsCommand(
    name: 'app:create-sample-data',
    description: 'Create sample data for all entities (15 associations, 11 PTFs, 25 projects, 35 events, 9 opportunities, 13 coalitions)',
)]
class CreateSampleDataCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SluggerInterface $slugger
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Creating sample data for Jamaity platform');

        // Create 15 Associations
        $this->createAssociations($io);
        
        // Create 11 PTFs
        $this->createPtfs($io);
        
        // Create 25 Projects
        $this->createProjects($io);
        
        // Create 35 Events
        $this->createEvents($io);
        
        // Create 9 Opportunities
        $this->createOpportunities($io);
        
        // Create 13 Coalitions
        $this->createCoalitions($io);

        $this->entityManager->flush();

        $io->success('Sample data created successfully!');
        $io->table(
            ['Entity', 'Count'],
            [
                ['Associations', '15'],
                ['PTFs', '11'],
                ['Projects', '25'],
                ['Events', '35'],
                ['Opportunities', '9'],
                ['Coalitions', '13']
            ]
        );

        return Command::SUCCESS;
    }

    private function createAssociations(SymfonyStyle $io): void
    {
        $io->section('Creating 15 Associations');
        
        $associationNames = [
            'Association Tunisienne pour le Développement Durable',
            'Jeunesse et Citoyenneté Active',
            'Femmes Leaders de Tunisie',
            'Association pour l\'Innovation Sociale',
            'Réseau des Entrepreneurs Sociaux',
            'Association de Protection de l\'Environnement',
            'Collectif pour l\'Éducation Populaire',
            'Association des Droits Humains',
            'Mouvement pour la Transparence',
            'Association Culturelle du Patrimoine',
            'Réseau de Solidarité Communautaire',
            'Association pour l\'Inclusion Numérique',
            'Collectif des Artisans Tunisiens',
            'Association de Développement Rural',
            'Mouvement Citoyen pour la Démocratie'
        ];

        $regions = ['Tunis', 'Sfax', 'Sousse', 'Kairouan', 'Bizerte', 'Gabès', 'Ariana', 'Monastir'];
        $themes = ['Environnement', 'Éducation', 'Santé', 'Culture', 'Économie sociale', 'Droits humains', 'Jeunesse', 'Femmes'];

        foreach ($associationNames as $index => $name) {
            $association = new Association();
            $association->setTitre($name);
            $association->setSlug($this->slugger->slug($name . '-' . ($index + 1))->lower());
            $association->setDescription('Description détaillée de ' . $name . '. Cette association œuvre pour le développement de la société civile tunisienne.');
            $association->setRegion($regions[array_rand($regions)]);
            $association->setDomaine($themes[array_rand($themes)]);
            $association->setDateFondation(new \DateTime('-' . rand(1, 5) . ' years'));
            $association->setStructure('Association');
            $association->setEmail('contact' . ($index + 1) . '@association.tn');
            $association->setTelephone('+216 ' . rand(20, 99) . ' ' . rand(100, 999) . ' ' . rand(100, 999));
            $association->setSiteWeb('https://www.association' . ($index + 1) . '.tn');
            $association->setPresident('Président ' . ($index + 1));
            $association->setTelephone2('+216 ' . rand(20, 99) . ' ' . rand(100, 999) . ' ' . rand(100, 999));
            $association->setAnneeFondation(date('Y') - rand(1, 5));
            
            $this->entityManager->persist($association);
        }
        
        $io->text('15 associations created');
    }

    private function createPtfs(SymfonyStyle $io): void
    {
        $io->section('Creating 11 PTFs');
        
        $ptfNames = [
            'Partenariat Technique Franco-Tunisien',
            'Coopération Allemande pour le Développement',
            'Programme d\'Appui à la Société Civile',
            'Initiative Européenne pour la Démocratie',
            'Fonds de Soutien aux ONG',
            'Programme de Renforcement Institutionnel',
            'Partenariat pour l\'Innovation Sociale',
            'Fonds d\'Appui aux Projets Communautaires',
            'Programme de Développement Local',
            'Initiative pour l\'Entrepreneuriat Social',
            'Fonds de Solidarité Internationale'
        ];

        $types = ['Gouvernemental', 'International', 'Privé', 'Mixte'];
        $secteurs = ['Développement', 'Éducation', 'Santé', 'Environnement', 'Économie', 'Social'];

        foreach ($ptfNames as $index => $name) {
            $ptf = new Ptf();
            $ptf->setTitre($name);
            $ptf->setSlug($this->slugger->slug($name . '-' . ($index + 1))->lower());
            $ptf->setDescription('Description du ' . $name . '. Ce partenaire technique et financier soutient le développement de la société civile.');
            $ptf->setMission('Mission du ' . $name);
            $ptf->setDateFondation(new \DateTime('-' . rand(2, 10) . ' years'));
            $ptf->setEmail('contact@ptf' . ($index + 1) . '.org');
            $ptf->setTelephone('+216 ' . rand(70, 79) . ' ' . rand(100, 999) . ' ' . rand(100, 999));
            $ptf->setSiteWeb('https://www.ptf' . ($index + 1) . '.org');
            $ptf->setAnnee(date('Y') - rand(2, 10));
            
            $this->entityManager->persist($ptf);
        }
        
        $io->text('11 PTFs created');
    }

    private function createProjects(SymfonyStyle $io): void
    {
        $io->section('Creating 25 Projects');
        
        $projectTitles = [
            'Projet de Développement Durable Communautaire',
            'Initiative Jeunesse et Innovation',
            'Programme d\'Autonomisation des Femmes',
            'Projet d\'Éducation Environnementale',
            'Initiative de Gouvernance Locale',
            'Projet de Préservation du Patrimoine',
            'Programme de Formation Professionnelle',
            'Initiative de Santé Communautaire',
            'Projet d\'Agriculture Durable',
            'Programme de Lutte contre la Pauvreté',
            'Initiative de Transformation Numérique',
            'Projet de Développement Rural',
            'Programme d\'Inclusion Sociale',
            'Initiative de Protection de l\'Enfance',
            'Projet de Développement Économique Local',
            'Programme de Sensibilisation Civique',
            'Initiative de Tourisme Durable',
            'Projet de Gestion des Déchets',
            'Programme de Promotion Culturelle',
            'Initiative de Microfinance',
            'Projet de Réhabilitation Urbaine',
            'Programme de Soutien aux Startups',
            'Initiative de Médiation Sociale',
            'Projet de Conservation Marine',
            'Programme de Développement Artistique'
        ];

        $regions = ['Tunis', 'Sfax', 'Sousse', 'Kairouan', 'Bizerte', 'Gabès', 'Ariana', 'Monastir', 'Nabeul', 'Mahdia'];
        $statuts = ['en_cours', 'termine', 'planifie'];

        foreach ($projectTitles as $index => $title) {
            $project = new Project();
            $project->setTitle($title);
            $project->setSlug($this->slugger->slug($title . '-' . ($index + 1))->lower());
            $project->setGeneralObjective('Objectif du ' . $title . ': contribuer au développement socio-économique de la région.');
            $project->setMoreDetails('Description détaillée du ' . $title . '. Ce projet vise à améliorer les conditions de vie des communautés locales.');
            $project->setRegion([$regions[array_rand($regions)]]);
            
            $startDate = new \DateTime('-' . rand(6, 24) . ' months');
            $project->setDateBegin($startDate);
            $project->setDateEnd((clone $startDate)->add(new \DateInterval('P' . rand(12, 36) . 'M')));
            
            $project->setWebsite('https://projet' . ($index + 1) . '.tn');
            
            $this->entityManager->persist($project);
        }
        
        $io->text('25 projects created');
    }

    private function createEvents(SymfonyStyle $io): void
    {
        $io->section('Creating 35 Events');
        
        $eventTypes = [
            'Conférence sur le Développement Durable',
            'Atelier de Formation en Leadership',
            'Séminaire sur l\'Innovation Sociale',
            'Forum de la Société Civile',
            'Colloque sur les Droits Humains',
            'Workshop sur l\'Entrepreneuriat',
            'Table Ronde sur l\'Environnement',
            'Symposium sur l\'Éducation',
            'Rencontre Régionale des Associations',
            'Journée de Sensibilisation'
        ];

        $regions = ['Tunis', 'Sfax', 'Sousse', 'Kairouan', 'Bizerte', 'Gabès', 'Ariana'];
        $statuts = ['planifie', 'en_cours', 'termine'];

        for ($i = 1; $i <= 35; $i++) {
            $event = new Event();
            $eventType = $eventTypes[array_rand($eventTypes)];
            $event->setTitre($eventType . ' #' . $i);
            $event->setSlug($this->slugger->slug($eventType . '-' . $i)->lower());
            $event->setDescription('Description de l\'événement ' . $eventType . '. Cet événement rassemble les acteurs de la société civile.');
            $event->setLieu($regions[array_rand($regions)]);
            $event->setStatut($statuts[array_rand($statuts)]);
            $event->setRegion([$regions[array_rand($regions)]]);
            
            $startDate = new \DateTime('+' . rand(-30, 90) . ' days');
            $event->setDateDebut($startDate);
            $event->setDateFin((clone $startDate)->add(new \DateInterval('P' . rand(1, 3) . 'D')));
            
            $this->entityManager->persist($event);
        }
        
        $io->text('35 events created');
    }

    private function createOpportunities(SymfonyStyle $io): void
    {
        $io->section('Creating 9 Opportunities');
        
        $opportunityTitles = [
            'Appel à Projets pour le Développement Durable',
            'Bourse de Formation en Leadership',
            'Concours d\'Innovation Sociale',
            'Programme de Mentorat pour Entrepreneurs',
            'Subvention pour Projets Communautaires',
            'Formation en Gestion de Projet',
            'Opportunité de Partenariat International',
            'Fonds de Soutien aux Initiatives Jeunes',
            'Programme d\'Échange Culturel'
        ];

        $types = OpportunityTypeEnum::getValues();
        $statuts = ['active', 'fermee', 'en_attente'];

        foreach ($opportunityTitles as $index => $title) {
            $opportunity = new Opportunity();
            $opportunity->setTitre($title);
            $opportunity->setOpportunityDetails('Description de l\'opportunité: ' . $title . '. Cette opportunité offre un soutien aux acteurs de la société civile.');
            $opportunity->setTypeOfOpportunities($types[array_rand($types)]);
            
            $opportunity->setDateCreation(new \DateTime('-' . rand(1, 30) . ' days'));
            $opportunity->setDueDate(new \DateTime('+' . rand(30, 90) . ' days'));
            
            $opportunity->setOrganisme('Organisme ' . ($index + 1));
            $opportunity->setRegions(['Tunis', 'Sfax']);
            $opportunity->setInterventionThemes(['Développement', 'Social']);
            
            $this->entityManager->persist($opportunity);
        }
        
        $io->text('9 opportunities created');
    }

    private function createCoalitions(SymfonyStyle $io): void
    {
        $io->section('Creating 13 Coalitions');
        
        $coalitionNames = [
            'Coalition pour la Transparence et la Gouvernance',
            'Réseau des Associations Environnementales',
            'Coalition pour les Droits des Femmes',
            'Alliance pour l\'Éducation Citoyenne',
            'Coalition contre la Corruption',
            'Réseau de Développement Local',
            'Coalition pour la Justice Sociale',
            'Alliance des Organisations de Jeunesse',
            'Coalition pour la Santé Communautaire',
            'Réseau des Entrepreneurs Sociaux',
            'Coalition pour la Culture et le Patrimoine',
            'Alliance pour l\'Innovation Technologique',
            'Coalition pour le Développement Durable'
        ];

        $themes = ['Gouvernance', 'Environnement', 'Droits humains', 'Éducation', 'Santé', 'Culture', 'Économie'];
        $statuts = ['active', 'inactive', 'en_formation'];

        foreach ($coalitionNames as $index => $name) {
            $coalition = new Coalition();
            $coalition->setTitre($name);
            $coalition->setSlug($this->slugger->slug($name . '-' . ($index + 1))->lower());
            $coalition->setDescription('Description de la ' . $name . '. Cette coalition rassemble plusieurs organisations autour d\'objectifs communs.');
            $coalition->setDomaine($themes[array_rand($themes)]);
            $coalition->setDateFondation(new \DateTime('-' . rand(1, 5) . ' years'));
            $coalition->setEmail('coalition' . ($index + 1) . '@jamaity.org');
            $coalition->setSiteWeb('https://coalition' . ($index + 1) . '.jamaity.org');
            $coalition->setPresident('Président Coalition ' . ($index + 1));
            $coalition->setStructure('Coalition');
            
            $this->entityManager->persist($coalition);
        }
        
        $io->text('13 coalitions created');
    }
}