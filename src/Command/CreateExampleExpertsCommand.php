<?php

namespace App\Command;

use App\Entity\Expert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsCommand(
    name: 'app:create-example-experts',
    description: 'Create 10 example experts with diverse profiles',
)]
class CreateExampleExpertsCommand extends Command
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

        $experts = [
            [
                'firstName' => 'Amina',
                'lastName' => 'Ben Salem',
                'email' => 'amina.bensalem@example.com',
                'phoneNumber' => '+216 20 123 456',
                'description' => 'Experte en développement durable et environnement avec plus de 15 ans d\'expérience dans la gestion de projets écologiques en Tunisie.',
                'areaOfExpertise' => 'Développement Durable',
                'region' => 'Tunis',
                'gender' => 'female',
                'birthday' => new \DateTime('1985-03-15'),
                'linkedin' => 'https://linkedin.com/in/amina-bensalem',
                'professionalExperience' => [
                    [
                        'position' => 'Directrice de Projet',
                        'company' => 'ONG Environnement Tunisie',
                        'startDate' => '2018',
                        'endDate' => null,
                        'description' => 'Gestion de projets de conservation marine et sensibilisation environnementale'
                    ],
                    [
                        'position' => 'Consultante Environnementale',
                        'company' => 'Cabinet Conseil Vert',
                        'startDate' => '2015',
                        'endDate' => '2018',
                        'description' => 'Conseil en politique environnementale pour les entreprises'
                    ]
                ],
                'training' => [
                    [
                        'degree' => 'Master en Sciences Environnementales',
                        'institution' => 'Université de Tunis El Manar',
                        'year' => '2010',
                        'description' => 'Spécialisation en gestion des ressources naturelles'
                    ]
                ]
            ],
            [
                'firstName' => 'Mohamed',
                'lastName' => 'Trabelsi',
                'email' => 'mohamed.trabelsi@example.com',
                'phoneNumber' => '+216 25 789 012',
                'description' => 'Spécialiste en droits humains et justice sociale, militant actif pour les libertés civiles en Tunisie.',
                'areaOfExpertise' => 'Droits Humains',
                'region' => 'Sfax',
                'gender' => 'male',
                'birthday' => new \DateTime('1978-11-22'),
                'linkedin' => 'https://linkedin.com/in/mohamed-trabelsi',
                'professionalExperience' => [
                    [
                        'position' => 'Coordinateur Régional',
                        'company' => 'Ligue Tunisienne des Droits de l\'Homme',
                        'startDate' => '2020',
                        'endDate' => null,
                        'description' => 'Coordination des activités de défense des droits humains dans la région de Sfax'
                    ]
                ],
                'training' => [
                    [
                        'degree' => 'Licence en Droit',
                        'institution' => 'Faculté de Droit de Sfax',
                        'year' => '2002',
                        'description' => 'Formation en droit public et droits de l\'homme'
                    ]
                ]
            ],
            [
                'firstName' => 'Leila',
                'lastName' => 'Mansouri',
                'email' => 'leila.mansouri@example.com',
                'phoneNumber' => '+216 22 345 678',
                'description' => 'Experte en égalité des genres et autonomisation des femmes, formatrice et consultante internationale.',
                'areaOfExpertise' => 'Égalité des Genres',
                'region' => 'Sousse',
                'gender' => 'female',
                'birthday' => new \DateTime('1982-07-08'),
                'linkedin' => 'https://linkedin.com/in/leila-mansouri',
                'professionalExperience' => [
                    [
                        'position' => 'Consultante Senior',
                        'company' => 'ONU Femmes Tunisie',
                        'startDate' => '2019',
                        'endDate' => null,
                        'description' => 'Développement de programmes d\'autonomisation économique des femmes'
                    ]
                ],
                'training' => [
                    [
                        'degree' => 'Master en Sociologie',
                        'institution' => 'Université de Sousse',
                        'year' => '2006',
                        'description' => 'Spécialisation en études de genre'
                    ]
                ]
            ],
            [
                'firstName' => 'Karim',
                'lastName' => 'Bouazizi',
                'email' => 'karim.bouazizi@example.com',
                'phoneNumber' => '+216 26 456 789',
                'description' => 'Expert en éducation et formation professionnelle, spécialisé dans l\'innovation pédagogique et l\'inclusion sociale.',
                'areaOfExpertise' => 'Éducation',
                'region' => 'Monastir',
                'gender' => 'male',
                'birthday' => new \DateTime('1980-12-03'),
                'linkedin' => 'https://linkedin.com/in/karim-bouazizi',
                'professionalExperience' => [
                    [
                        'position' => 'Directeur Pédagogique',
                        'company' => 'Institut de Formation Professionnelle',
                        'startDate' => '2017',
                        'endDate' => null,
                        'description' => 'Développement de programmes de formation innovants'
                    ]
                ],
                'training' => [
                    [
                        'degree' => 'Doctorat en Sciences de l\'Éducation',
                        'institution' => 'Université de Monastir',
                        'year' => '2012',
                        'description' => 'Recherche en pédagogie numérique'
                    ]
                ]
            ],
            [
                'firstName' => 'Fatma',
                'lastName' => 'Khelifi',
                'email' => 'fatma.khelifi@example.com',
                'phoneNumber' => '+216 23 567 890',
                'description' => 'Spécialiste en santé publique et promotion de la santé communautaire, experte en épidémiologie.',
                'areaOfExpertise' => 'Santé Publique',
                'region' => 'Kairouan',
                'gender' => 'female',
                'birthday' => new \DateTime('1975-09-14'),
                'linkedin' => 'https://linkedin.com/in/fatma-khelifi',
                'professionalExperience' => [
                    [
                        'position' => 'Médecin Épidémiologiste',
                        'company' => 'Ministère de la Santé',
                        'startDate' => '2005',
                        'endDate' => null,
                        'description' => 'Surveillance épidémiologique et prévention des maladies'
                    ]
                ],
                'training' => [
                    [
                        'degree' => 'Doctorat en Médecine',
                        'institution' => 'Faculté de Médecine de Tunis',
                        'year' => '2000',
                        'description' => 'Spécialisation en santé publique'
                    ]
                ]
            ],
            [
                'firstName' => 'Youssef',
                'lastName' => 'Gharbi',
                'email' => 'youssef.gharbi@example.com',
                'phoneNumber' => '+216 24 678 901',
                'description' => 'Expert en développement économique local et entrepreneuriat social, consultant en microfinance.',
                'areaOfExpertise' => 'Développement Économique',
                'region' => 'Gabès',
                'gender' => 'male',
                'birthday' => new \DateTime('1983-05-27'),
                'linkedin' => 'https://linkedin.com/in/youssef-gharbi',
                'professionalExperience' => [
                    [
                        'position' => 'Responsable Programmes',
                        'company' => 'Enda Inter-Arabe',
                        'startDate' => '2016',
                        'endDate' => null,
                        'description' => 'Développement de programmes de microfinance et entrepreneuriat'
                    ]
                ],
                'training' => [
                    [
                        'degree' => 'Master en Économie du Développement',
                        'institution' => 'Institut Supérieur de Gestion de Tunis',
                        'year' => '2008',
                        'description' => 'Spécialisation en finance solidaire'
                    ]
                ]
            ],
            [
                'firstName' => 'Sonia',
                'lastName' => 'Jemli',
                'email' => 'sonia.jemli@example.com',
                'phoneNumber' => '+216 27 789 012',
                'description' => 'Experte en gouvernance et transparence, spécialisée dans la lutte contre la corruption et la bonne gouvernance.',
                'areaOfExpertise' => 'Gouvernance',
                'region' => 'Bizerte',
                'gender' => 'female',
                'birthday' => new \DateTime('1979-01-19'),
                'linkedin' => 'https://linkedin.com/in/sonia-jemli',
                'professionalExperience' => [
                    [
                        'position' => 'Analyste Senior',
                        'company' => 'Transparency International Tunisie',
                        'startDate' => '2014',
                        'endDate' => null,
                        'description' => 'Recherche et plaidoyer pour la transparence gouvernementale'
                    ]
                ],
                'training' => [
                    [
                        'degree' => 'Master en Administration Publique',
                        'institution' => 'École Nationale d\'Administration',
                        'year' => '2004',
                        'description' => 'Formation en gestion publique et gouvernance'
                    ]
                ]
            ],
            [
                'firstName' => 'Hichem',
                'lastName' => 'Zouari',
                'email' => 'hichem.zouari@example.com',
                'phoneNumber' => '+216 28 890 123',
                'description' => 'Spécialiste en agriculture durable et sécurité alimentaire, expert en développement rural.',
                'areaOfExpertise' => 'Agriculture Durable',
                'region' => 'Béja',
                'gender' => 'male',
                'birthday' => new \DateTime('1976-04-11'),
                'linkedin' => 'https://linkedin.com/in/hichem-zouari',
                'professionalExperience' => [
                    [
                        'position' => 'Coordinateur Technique',
                        'company' => 'Programme Alimentaire Mondial',
                        'startDate' => '2013',
                        'endDate' => null,
                        'description' => 'Développement de programmes de sécurité alimentaire'
                    ]
                ],
                'training' => [
                    [
                        'degree' => 'Ingénieur Agronome',
                        'institution' => 'Institut National Agronomique de Tunisie',
                        'year' => '2001',
                        'description' => 'Spécialisation en développement rural'
                    ]
                ]
            ],
            [
                'firstName' => 'Rim',
                'lastName' => 'Abidi',
                'email' => 'rim.abidi@example.com',
                'phoneNumber' => '+216 29 901 234',
                'description' => 'Experte en communication et plaidoyer, spécialisée dans les campagnes de sensibilisation et mobilisation sociale.',
                'areaOfExpertise' => 'Communication',
                'region' => 'Nabeul',
                'gender' => 'female',
                'birthday' => new \DateTime('1987-08-25'),
                'linkedin' => 'https://linkedin.com/in/rim-abidi',
                'professionalExperience' => [
                    [
                        'position' => 'Responsable Communication',
                        'company' => 'Forum Tunisien pour les Droits Économiques et Sociaux',
                        'startDate' => '2015',
                        'endDate' => null,
                        'description' => 'Développement de stratégies de communication et plaidoyer'
                    ]
                ],
                'training' => [
                    [
                        'degree' => 'Master en Communication',
                        'institution' => 'Institut de Presse et des Sciences de l\'Information',
                        'year' => '2011',
                        'description' => 'Spécialisation en communication sociale'
                    ]
                ]
            ],
            [
                'firstName' => 'Nabil',
                'lastName' => 'Hamdi',
                'email' => 'nabil.hamdi@example.com',
                'phoneNumber' => '+216 21 012 345',
                'description' => 'Expert en jeunesse et participation citoyenne, animateur de programmes d\'engagement civique des jeunes.',
                'areaOfExpertise' => 'Jeunesse et Citoyenneté',
                'region' => 'Médenine',
                'gender' => 'male',
                'birthday' => new \DateTime('1990-06-30'),
                'linkedin' => 'https://linkedin.com/in/nabil-hamdi',
                'professionalExperience' => [
                    [
                        'position' => 'Coordinateur Jeunesse',
                        'company' => 'Association Tunisienne de la Jeunesse',
                        'startDate' => '2018',
                        'endDate' => null,
                        'description' => 'Animation de programmes de leadership jeunesse'
                    ]
                ],
                'training' => [
                    [
                        'degree' => 'Licence en Sciences Politiques',
                        'institution' => 'Faculté de Droit et des Sciences Politiques de Tunis',
                        'year' => '2014',
                        'description' => 'Formation en participation citoyenne'
                    ]
                ]
            ]
        ];

        $io->title('Creating 10 Example Experts');
        $io->progressStart(count($experts));

        foreach ($experts as $expertData) {
            $expert = new Expert();
            $expert->setFirstName($expertData['firstName']);
            $expert->setLastName($expertData['lastName']);
            $expert->setEmail($expertData['email']);
            $expert->setPhoneNumber($expertData['phoneNumber']);
            $expert->setDescription($expertData['description']);
            $expert->setAreaOfExpertise($expertData['areaOfExpertise']);
            $expert->setRegion($expertData['region']);
            $expert->setGender($expertData['gender']);
            $expert->setBirthday($expertData['birthday']);
            $expert->setLinkedin($expertData['linkedin']);
            $expert->setProfessionalExperience($expertData['professionalExperience']);
            $expert->setTraining($expertData['training']);
            
            // Generate slug
            $slug = $this->slugger->slug($expertData['firstName'] . ' ' . $expertData['lastName'])->lower();
            $expert->setSlug($slug);

            $this->entityManager->persist($expert);
            $io->progressAdvance();
        }

        $this->entityManager->flush();
        $io->progressFinish();

        $io->success('Successfully created 10 example experts!');
        $io->table(
            ['Name', 'Area of Expertise', 'Region', 'Email'],
            array_map(function($expert) {
                return [
                    $expert['firstName'] . ' ' . $expert['lastName'],
                    $expert['areaOfExpertise'],
                    $expert['region'],
                    $expert['email']
                ];
            }, $experts)
        );

        return Command::SUCCESS;
    }
}