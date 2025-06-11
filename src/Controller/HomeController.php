<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Association;
use App\Entity\Coalition;
use App\Entity\Event;
use App\Entity\Expert;
use App\Entity\Opportunity;
use App\Entity\Organization;
use App\Entity\Project;
use App\Entity\Ptf;
use App\Entity\Resource;
use App\Enum\ExpertiseEnum;
use App\Enum\ThemeEnum;
use App\Enum\RegionEnum;
use App\Repository\ExpertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Fetch the latest 9 published articles for slider
        $latestArticles = $entityManager->getRepository(Actualite::class)
            ->createQueryBuilder('a')
            ->where('a.statut = :statut')
            ->setParameter('statut', 'publie')
            ->orderBy('a.datePublication', 'DESC')
            ->setMaxResults(9)
            ->getQuery()
            ->getResult();

        // Fetch associations for slider
        $associations = $entityManager->getRepository(Association::class)
            ->createQueryBuilder('a')
            ->orderBy('a.titre', 'ASC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult();

        // Fetch coalitions for slider
        $coalitions = $entityManager->getRepository(Coalition::class)
            ->createQueryBuilder('c')
            ->orderBy('c.titre', 'ASC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult();

        // Fetch PTFs for slider
        $ptfs = $entityManager->getRepository(Ptf::class)
            ->createQueryBuilder('p')
            ->orderBy('p.titre', 'ASC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult();

        // Fetch opportunities for statistics
        $opportunities = $entityManager->getRepository(Opportunity::class)
            ->createQueryBuilder('o')
            ->where('o.statut = :statut')
            ->setParameter('statut', 'active')
            ->getQuery()
            ->getResult();

        // Fetch upcoming events (next 30 days)
        $upcomingEvents = $entityManager->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->where('e.dateDebut >= :today')
            ->andWhere('e.dateDebut <= :futureDate')
            ->andWhere('e.statut != :cancelled')
            ->setParameter('today', new \DateTime())
            ->setParameter('futureDate', new \DateTime('+30 days'))
            ->setParameter('cancelled', 'annule')
            ->orderBy('e.dateDebut', 'ASC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult();

        // Fetch the latest 10 experts for slider
        $latestExperts = $entityManager->getRepository(Expert::class)
            ->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        // Fetch the latest 8 projects for slider
        $latestProjects = $entityManager->getRepository(Project::class)
            ->createQueryBuilder('p')
            ->orderBy('p.dateBegin', 'DESC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult();

        // Get counts for statistics section
        $associationsCount = $entityManager->getRepository(Association::class)
            ->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $ptfsCount = $entityManager->getRepository(Ptf::class)
            ->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $projectsCount = $entityManager->getRepository(Project::class)
            ->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $expertsCount = $entityManager->getRepository(Expert::class)
            ->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $eventsCount = $entityManager->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $opportunitiesCount = $entityManager->getRepository(Opportunity::class)
            ->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $coalitionsCount = $entityManager->getRepository(Coalition::class)
            ->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // Fetch organizations with resources for resources center
        $organizationsWithResources = $entityManager->getRepository(Organization::class)
            ->createQueryBuilder('o')
            ->leftJoin('o.resources', 'r')
            ->where('r.id IS NOT NULL')
            ->groupBy('o.id')
            ->orderBy('o.slug', 'ASC')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'latestArticles' => $latestArticles,
            'associations' => $associations,
            'coalitions' => $coalitions,
            'ptfs' => $ptfs,
            'opportunities' => $opportunities,
            'upcomingEvents' => $upcomingEvents,
            'latestExperts' => $latestExperts,
            'latestProjects' => $latestProjects,
            'associationsCount' => $associationsCount,
            'ptfsCount' => $ptfsCount,
            'coalitionsCount' => $coalitionsCount,
            'projectsCount' => $projectsCount,
            'expertsCount' => $expertsCount,
            'eventsCount' => $eventsCount,
            'opportunitiesCount' => $opportunitiesCount,
            'organizationsWithResources' => $organizationsWithResources,
        ]);
    }

    #[Route('/jamaity', name: 'app_jamaity')]
    public function jamaity(): Response
    {
        return $this->render('home/jamaity.html.twig');
    }

    #[Route('/societe-civile', name: 'app_societe_civile')]
    public function societeCivile(): Response
    {
        return $this->render('home/societe_civile.html.twig');
    }

    #[Route('/opportunities', name: 'app_opportunities')]
    public function opportunities(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Opportunity::class);
        
        // Get filter parameters
        $typeOfOpportunities = $request->query->get('type');
        $regions = $request->query->get('regions');
        $interventionThemes = $request->query->get('themes');
        $search = $request->query->get('search');
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        // Get opportunities expiring in 10 days
        $expiringDate = new \DateTime('+10 days');
        $expiringOpportunities = $repository->createQueryBuilder('o')
            ->where('o.dueDate IS NOT NULL')
            ->andWhere('o.dueDate <= :expiringDate')
            ->andWhere('o.dueDate >= :today')
            ->andWhere('o.statut = :statut')
            ->setParameter('expiringDate', $expiringDate)
            ->setParameter('today', new \DateTime())
            ->setParameter('statut', 'active')
            ->orderBy('o.dueDate', 'ASC')
            ->getQuery()
            ->getResult();
        
        // Build main query for opportunities list
        $qb = $repository->createQueryBuilder('o')
            ->where('o.statut = :statut')
            ->setParameter('statut', 'active');
        
        if ($search) {
            $qb->andWhere('o.titre LIKE :search OR o.opportunityDetails LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
        
        if ($typeOfOpportunities) {
            $qb->andWhere('o.typeOfOpportunities = :type')
               ->setParameter('type', $typeOfOpportunities);
        }
        
        if ($regions) {
            $qb->andWhere('JSON_CONTAINS(o.regions, :regions) = 1')
               ->setParameter('regions', json_encode([$regions]));
        }
        
        if ($interventionThemes) {
            $qb->andWhere('JSON_CONTAINS(o.interventionThemes, :themes) = 1')
               ->setParameter('themes', json_encode([$interventionThemes]));
        }
        
        // Get total count for pagination
        $totalQuery = clone $qb;
        $total = $totalQuery->select('COUNT(o.id)')->getQuery()->getSingleScalarResult();
        $totalPages = ceil($total / $limit);
        
        // Get paginated results
        $opportunities = $qb->orderBy('o.dateCreation', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        
        return $this->render('home/opportunities.html.twig', [
            'opportunities' => $opportunities,
            'expiringOpportunities' => $expiringOpportunities,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'filters' => [
                'type' => $typeOfOpportunities,
                'regions' => $regions,
                'themes' => $interventionThemes,
                'search' => $search
            ],
            'validTypes' => Opportunity::getValidOpportunityTypes(),
            'validRegions' => Opportunity::getValidRegions(),
            'validThemes' => ThemeEnum::getChoices()
        ]);
    }
    
    #[Route('/projects', name: 'app_projects')]
    public function projects(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Project::class);
        
        // Get filter parameters
        $search = $request->query->get('search');
        $region = $request->query->get('region');
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        // Build query for projects list
        $qb = $repository->createQueryBuilder('p');
        
        if ($search) {
            $qb->andWhere('p.title LIKE :search OR p.generalObjective LIKE :search OR p.moreDetails LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
        
        if ($region) {
            $qb->andWhere('p.region = :region')
               ->setParameter('region', $region);
        }
        
        // Get total count for pagination
        $totalQuery = clone $qb;
        $total = $totalQuery->select('COUNT(p.id)')->getQuery()->getSingleScalarResult();
        $totalPages = ceil($total / $limit);
        
        // Get paginated results
        $projects = $qb->orderBy('p.dateBegin', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        
        return $this->render('home/projects.html.twig', [
            'projects' => $projects,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'filters' => [
                'search' => $search,
                'region' => $region
            ]
        ]);
    }
    
    #[Route('/events', name: 'app_events')]
    public function events(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Event::class);
        
        // Get filter parameters
        $region = $request->query->get('region');
        $dateFrom = $request->query->get('date_from');
        $dateTo = $request->query->get('date_to');
        $search = $request->query->get('search');
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        // Get upcoming events (next 30 days)
        $upcomingDate = new \DateTime('+30 days');
        $upcomingEvents = $repository->createQueryBuilder('e')
            ->where('e.dateDebut IS NOT NULL')
            ->andWhere('e.dateDebut >= :today')
            ->andWhere('e.dateDebut <= :upcomingDate')
            ->andWhere('e.statut != :cancelled')
            ->setParameter('today', new \DateTime())
            ->setParameter('upcomingDate', $upcomingDate)
            ->setParameter('cancelled', 'annule')
            ->orderBy('e.dateDebut', 'ASC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
        
        // Build main query for events list
        $qb = $repository->createQueryBuilder('e')
            ->where('e.statut != :cancelled')
            ->setParameter('cancelled', 'annule');
        
        if ($search) {
            $qb->andWhere('e.titre LIKE :search OR e.description LIKE :search OR e.lieu LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
        
        if ($region) {
            $qb->andWhere('JSON_CONTAINS(e.region, :region) = 1')
               ->setParameter('region', json_encode([$region]));
        }
        
        if ($dateFrom) {
            $dateFromObj = \DateTime::createFromFormat('Y-m-d', $dateFrom);
            if ($dateFromObj) {
                $qb->andWhere('e.dateDebut >= :dateFrom')
                   ->setParameter('dateFrom', $dateFromObj);
            }
        }
        
        if ($dateTo) {
            $dateToObj = \DateTime::createFromFormat('Y-m-d', $dateTo);
            if ($dateToObj) {
                $dateToObj->setTime(23, 59, 59); // End of day
                $qb->andWhere('e.dateDebut <= :dateTo')
                   ->setParameter('dateTo', $dateToObj);
            }
        }
        
        // Get total count for pagination
        $totalQuery = clone $qb;
        $total = $totalQuery->select('COUNT(e.id)')->getQuery()->getSingleScalarResult();
        $totalPages = ceil($total / $limit);
        
        // Get paginated results
        $events = $qb->orderBy('e.dateDebut', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        
        return $this->render('home/events.html.twig', [
            'events' => $events,
            'upcomingEvents' => $upcomingEvents,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'filters' => [
                'region' => $region,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'search' => $search
            ],
            'validRegions' => Event::getValidRegions()
        ]);
    }
    
    #[Route('/agenda', name: 'app_agenda')]
    public function agenda(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Event::class);
        
        // Get all events for the calendar (not cancelled)
        $events = $repository->createQueryBuilder('e')
            ->where('e.statut != :cancelled')
            ->setParameter('cancelled', 'annule')
            ->orderBy('e.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();
        
        return $this->render('home/agenda.html.twig', [
            'events' => $events
        ]);
    }

    #[Route('/event/{slug}', name: 'app_event_detail')]
    public function eventDetail(string $slug, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Event::class);
        $event = $repository->findOneBy(['slug' => $slug]);
        
        if (!$event) {
            throw $this->createNotFoundException('Événement non trouvé');
        }
        
        return $this->render('home/event_detail.html.twig', [
            'event' => $event
        ]);
    }
    
    #[Route('/opportunity/{slug}', name: 'app_opportunity_detail')]
    public function opportunityDetail(string $slug, EntityManagerInterface $entityManager): Response
    {
        $opportunity = $entityManager->getRepository(Opportunity::class)
            ->createQueryBuilder('o')
            ->where('o.slug = :slug')
            ->andWhere('o.statut = :statut')
            ->setParameter('slug', $slug)
            ->setParameter('statut', 'active')
            ->getQuery()
            ->getOneOrNullResult();

        if (!$opportunity) {
            throw $this->createNotFoundException('Opportunity not found');
        }

        return $this->render('home/opportunity_detail.html.twig', [
            'opportunity' => $opportunity
        ]);
    }

    #[Route('/actualites', name: 'app_actualites')]
    public function actualites(EntityManagerInterface $entityManager): Response
    {
        // Fetch all published articles ordered by publication date (newest first)
        $articles = $entityManager->getRepository(Actualite::class)
            ->createQueryBuilder('a')
            ->where('a.statut = :statut')
            ->setParameter('statut', 'publie')
            ->orderBy('a.datePublication', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('home/actualites.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/actualite/{slug}', name: 'app_actualite_detail')]
    public function actualiteDetail(string $slug, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(Actualite::class)
            ->createQueryBuilder('a')
            ->where('a.slug = :slug')
            ->andWhere('a.statut = :statut')
            ->setParameter('slug', $slug)
            ->setParameter('statut', 'publie')
            ->getQuery()
            ->getOneOrNullResult();

        if (!$article) {
            throw $this->createNotFoundException('Article not found');
        }

        return $this->render('home/actualite_detail.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/e-learning', name: 'app_elearning')]
    public function elearning(): Response
    {
        return $this->render('home/elearning.html.twig');
    }

    #[Route('/maps', name: 'app_maps')]
    public function maps(EntityManagerInterface $entityManager): Response
    {
        // Fetch all associations with their regions
        $associations = $entityManager->getRepository(Association::class)
            ->createQueryBuilder('a')
            ->select('a.lieux as region, COUNT(a.id) as count')
            ->groupBy('a.lieux')
            ->getQuery()
            ->getResult();

        // Fetch all coalitions with their regions
        $coalitions = $entityManager->getRepository(Coalition::class)
            ->createQueryBuilder('c')
            ->select('c.lieux as region, COUNT(c.id) as count')
            ->groupBy('c.lieux')
            ->getQuery()
            ->getResult();

        // Fetch all PTFs with their regions
        $ptfs = $entityManager->getRepository(Ptf::class)
            ->createQueryBuilder('p')
            ->select('p.lieux as region, COUNT(p.id) as count')
            ->groupBy('p.lieux')
            ->getQuery()
            ->getResult();

        // Fetch all events with their regions
        $events = $entityManager->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->select('e.lieu as region, COUNT(e.id) as count')
            ->where('e.dateDebut >= :today')
            ->setParameter('today', new \DateTime())
            ->groupBy('e.lieu')
            ->getQuery()
            ->getResult();

        // Prepare region statistics
        $regionStats = [];
        $tunisianRegions = [
            'Tunis', 'Ariana', 'Ben Arous', 'Mannouba', 'Zaghouan',
            'Nabeul', 'Bizerte', 'Beja', 'Sousse', 'Monastir', 'Mahdia',
            'Sfax', 'Kairouan', 'Kasserine', 'Sidi Bouzid', 'Gafsa',
            'Tozeur', 'Kebili', 'Gabes', 'Medenine', 'Tataouine',
            'Jendouba', 'Kef', 'Siliana'
        ];

        // Initialize all regions with zero counts
        foreach ($tunisianRegions as $region) {
            $regionStats[$region] = [
                'associations' => 0,
                'coalitions' => 0,
                'ptfs' => 0,
                'events' => 0
            ];
        }

        // Populate association counts
        foreach ($associations as $assoc) {
            if ($assoc['region'] && isset($regionStats[$assoc['region']])) {
                $regionStats[$assoc['region']]['associations'] = $assoc['count'];
            }
        }

        // Populate coalition counts
        foreach ($coalitions as $coalition) {
            if ($coalition['region'] && isset($regionStats[$coalition['region']])) {
                $regionStats[$coalition['region']]['coalitions'] = $coalition['count'];
            }
        }

        // Populate PTF counts
        foreach ($ptfs as $ptf) {
            if ($ptf['region'] && isset($regionStats[$ptf['region']])) {
                $regionStats[$ptf['region']]['ptfs'] = $ptf['count'];
            }
        }

        // Populate event counts
        foreach ($events as $event) {
            if ($event['region'] && isset($regionStats[$event['region']])) {
                $regionStats[$event['region']]['events'] = $event['count'];
            }
        }

        return $this->render('home/maps.html.twig', [
            'regionStats' => $regionStats,
            'associations' => $associations,
            'coalitions' => $coalitions,
            'ptfs' => $ptfs,
            'events' => $events,
        ]);
    }

    #[Route('/maps/region/{region}', name: 'app_maps_region_data', methods: ['GET'])]
    public function getRegionData(string $region, EntityManagerInterface $entityManager): Response
    {
        // Fetch associations in the region
        $associations = $entityManager->getRepository(Association::class)
            ->createQueryBuilder('a')
            ->where('a.lieux = :region')
            ->setParameter('region', $region)
            ->orderBy('a.titre', 'ASC')
            ->getQuery()
            ->getResult();

        // Fetch coalitions in the region
        $coalitions = $entityManager->getRepository(Coalition::class)
            ->createQueryBuilder('c')
            ->where('c.lieux = :region')
            ->setParameter('region', $region)
            ->orderBy('c.titre', 'ASC')
            ->getQuery()
            ->getResult();

        // Fetch PTFs in the region
        $ptfs = $entityManager->getRepository(Ptf::class)
            ->createQueryBuilder('p')
            ->where('p.lieux = :region')
            ->setParameter('region', $region)
            ->orderBy('p.titre', 'ASC')
            ->getQuery()
            ->getResult();

        // Fetch events in the region
        $events = $entityManager->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->where('e.lieu = :region')
            ->andWhere('e.dateDebut >= :today')
            ->setParameter('region', $region)
            ->setParameter('today', new \DateTime())
            ->orderBy('e.dateDebut', 'ASC')
            ->getQuery()
            ->getResult();

        // Prepare data for JSON response
        $data = [
            'region' => $region,
            'stats' => [
                'associations' => count($associations),
                'coalitions' => count($coalitions),
                'ptfs' => count($ptfs),
                'events' => count($events)
            ],
            'associations' => array_map(function($assoc) {
                return [
                    'id' => $assoc->getId(),
                    'titre' => $assoc->getTitre(),
                    'description' => $assoc->getDescription(),
                    'domaine' => $assoc->getDomaine(),
                    'logo' => $assoc->getLogo()
                ];
            }, $associations),
            'coalitions' => array_map(function($coalition) {
                return [
                    'id' => $coalition->getId(),
                    'titre' => $coalition->getTitre(),
                    'description' => $coalition->getDescription(),
                    'domaine' => $coalition->getDomaine(),
                    'logo' => $coalition->getLogo()
                ];
            }, $coalitions),
            'ptfs' => array_map(function($ptf) {
                return [
                    'id' => $ptf->getId(),
                    'titre' => $ptf->getTitre(),
                    'description' => $ptf->getDescription(),
                    'domaine' => $ptf->getDomaine(),
                    'logo' => $ptf->getLogo()
                ];
            }, $ptfs),
            'events' => array_map(function($event) {
                return [
                    'id' => $event->getId(),
                    'titre' => $event->getTitre(),
                    'description' => $event->getDescription(),
                    'dateDebut' => $event->getDateDebut()->format('Y-m-d H:i'),
                    'dateFin' => $event->getDateFin() ? $event->getDateFin()->format('Y-m-d H:i') : null,
                    'lieu' => $event->getLieu(),
                    'statut' => $event->getStatut()
                ];
            }, $events)
        ];

        return $this->json($data);
    }

    #[Route('/ptfs', name: 'app_ptfs')]
    public function ptfs(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Ptf::class);
        
        // Get filter parameters
        $region = $request->query->get('region');
        $domaine = $request->query->get('domaine');
        $search = $request->query->get('search');
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        // Build query
        $qb = $repository->createQueryBuilder('p');
        
        if ($search) {
            $qb->andWhere('p.titre LIKE :search OR p.description LIKE :search OR p.abreviation LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
        
        if ($region) {
            $qb->andWhere('p.region = :region')
               ->setParameter('region', $region);
        }
        
        if ($domaine) {
            $qb->andWhere('p.domaine = :domaine')
               ->setParameter('domaine', $domaine);
        }
        
        // Get total count for pagination
        $totalQuery = clone $qb;
        $total = $totalQuery->select('COUNT(p.id)')->getQuery()->getSingleScalarResult();
        $totalPages = ceil($total / $limit);
        
        // Get results with pagination
        $ptfs = $qb->orderBy('p.titre', 'ASC')
                   ->setFirstResult($offset)
                   ->setMaxResults($limit)
                   ->getQuery()
                   ->getResult();
        
        return $this->render('home/ptfs.html.twig', [
             'ptfs' => $ptfs,
             'currentPage' => $page,
             'totalPages' => $totalPages,
             'total' => $total,
             'domaines' => ThemeEnum::getChoices(),
             'current_domaine' => $domaine
         ]);
    }

    #[Route('/ptf/{slug}', name: 'app_ptf_detail')]
    public function ptfDetail(string $slug, EntityManagerInterface $entityManager): Response
    {
        $ptf = $entityManager->getRepository(Ptf::class)
            ->createQueryBuilder('p')
            ->where('p.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$ptf) {
            throw $this->createNotFoundException('PTF non trouvée');
        }

        // Fetch related events
        $events = $entityManager->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->join('e.organizations', 'org')
            ->where('org = :ptf')
            ->setParameter('ptf', $ptf)
            ->orderBy('e.dateDebut', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();

        // Fetch related opportunities
        $opportunities = $entityManager->getRepository(Opportunity::class)
            ->createQueryBuilder('o')
            ->where('o.organizationRelated = :ptf')
            ->setParameter('ptf', $ptf)
            ->orderBy('o.dateCreation', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();

        // Fetch latest published news (no organization relationship exists in Actualite entity)
        $actualites = $entityManager->getRepository(Actualite::class)
            ->createQueryBuilder('a')
            ->where('a.statut = :statut')
            ->setParameter('statut', 'publie')
            ->orderBy('a.datePublication', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();

        return $this->render('home/ptf_detail.html.twig', [
            'ptf' => $ptf,
            'events' => $events,
            'opportunities' => $opportunities,
            'actualites' => $actualites,
        ]);
    }

    #[Route('/experts', name: 'app_experts')]
    public function experts(Request $request, EntityManagerInterface $entityManager): Response
    {
        $search = $request->query->get('search', '');
        $region = $request->query->get('region', '');
        $areaOfExpertise = $request->query->get('area_of_expertise', '');
        
        $queryBuilder = $entityManager->getRepository(\App\Entity\Expert::class)
            ->createQueryBuilder('e')
            ->orderBy('e.firstName', 'ASC');
        
        if (!empty($search)) {
            $queryBuilder->andWhere('e.firstName LIKE :search OR e.lastName LIKE :search OR e.description LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }
        
        if (!empty($region)) {
            $queryBuilder->andWhere('e.region = :region')
                ->setParameter('region', $region);
        }
        
        if (!empty($areaOfExpertise)) {
            $queryBuilder->andWhere('e.areaOfExpertise = :areaOfExpertise')
                ->setParameter('areaOfExpertise', $areaOfExpertise);
        }
        
        $experts = $queryBuilder->getQuery()->getResult();
        
        // Get unique regions for filters
        $regions = $entityManager->getRepository(\App\Entity\Expert::class)
            ->createQueryBuilder('e')
            ->select('DISTINCT e.region')
            ->where('e.region IS NOT NULL')
            ->orderBy('e.region', 'ASC')
            ->getQuery()
            ->getSingleColumnResult();
            
        // Use ExpertiseEnum for areas of expertise
        $areasOfExpertise = ExpertiseEnum::getValues();
        
        return $this->render('home/experts.html.twig', [
            'experts' => $experts,
            'regions' => $regions,
            'areasOfExpertise' => $areasOfExpertise,
            'current_search' => $search,
            'current_region' => $region,
            'current_area_of_expertise' => $areaOfExpertise,
            'total' => count($experts),
        ]);
    }
    
    #[Route('/expert/{slug}', name: 'app_expert_detail')]
    public function expertDetail(string $slug, EntityManagerInterface $entityManager): Response
    {
        $expert = $entityManager->getRepository(\App\Entity\Expert::class)
            ->findOneBy(['slug' => $slug]);
            
        if (!$expert) {
            throw $this->createNotFoundException('Expert not found');
        }
        
        return $this->render('home/expert_detail.html.twig', [
            'expert' => $expert,
        ]);
    }

    #[Route('/associations', name: 'app_associations')]
    public function associations(Request $request, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Association::class);
        
        // Get filter parameters
        $region = $request->query->get('region');
        $domaine = $request->query->get('domaine');
        $search = $request->query->get('search');
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        // Build query
        $qb = $repository->createQueryBuilder('a');
        
        if ($region) {
            $qb->andWhere('a.region = :region')
               ->setParameter('region', $region);
        }
        
        if ($domaine) {
            $qb->andWhere('a.domaine = :domaine')
               ->setParameter('domaine', $domaine);
        }
        
        if ($search) {
            $qb->andWhere('a.titre LIKE :search OR a.description LIKE :search OR a.descriptionPresentation LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
        
        // Get total count for pagination
        $totalQuery = clone $qb;
        $total = $totalQuery->select('COUNT(a.id)')->getQuery()->getSingleScalarResult();
        
        // Get associations for current page
        $associations = $qb->setFirstResult($offset)
                          ->setMaxResults($limit)
                          ->getQuery()
                          ->getResult();
        
        // Calculate pagination info
        $totalPages = ceil($total / $limit);
        
        // Get filter options
        $regions = RegionEnum::getChoices();
        $domaines = ThemeEnum::getChoices();

        return $this->render('home/associations.html.twig', [
            'associations' => $associations,
            'regions' => $regions,
            'domaines' => $domaines,
            'current_region' => $region,
            'current_domaine' => $domaine,
            'current_search' => $search,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total' => $total
        ]);
    }

    #[Route('/association/{slug}', name: 'app_association_detail')]
    public function associationDetail(string $slug, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Association::class);
        $association = $repository->findOneBy(['slug' => $slug]);
        
        if (!$association) {
            throw $this->createNotFoundException('Association not found');
        }
        
        // Get related events
        $events = $entityManager->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->join('e.organizations', 'o')
            ->where('o.id = :associationId')
            ->setParameter('associationId', $association->getId())
            ->orderBy('e.dateDebut', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        
        // Get related opportunities
        $opportunities = $entityManager->getRepository(Opportunity::class)
            ->createQueryBuilder('op')
            ->where('op.organizationRelated = :association OR (op.organisme = :associationName OR op.organisme LIKE :associationSearch)')
            ->setParameter('association', $association)
            ->setParameter('associationName', $association->getTitre())
            ->setParameter('associationSearch', '%' . $association->getTitre() . '%')
            ->orderBy('op.dateCreation', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        
        // Get related projects
        $projects = $entityManager->getRepository(Project::class)
            ->createQueryBuilder('p')
            ->join('p.organizations', 'o')
            ->where('o.id = :associationId')
            ->setParameter('associationId', $association->getId())
            ->orderBy('p.dateBegin', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        
        // Get related news (actualités)
        $actualites = $entityManager->getRepository(Actualite::class)
            ->createQueryBuilder('a')
            ->where('a.statut = :statut')
            ->andWhere('a.contenu LIKE :associationSearch OR a.titre LIKE :associationSearch')
            ->setParameter('statut', 'publié')
            ->setParameter('associationSearch', '%' . $association->getTitre() . '%')
            ->orderBy('a.datePublication', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        
        return $this->render('home/association_detail.html.twig', [
            'association' => $association,
            'events' => $events,
            'opportunities' => $opportunities,
            'projects' => $projects,
            'actualites' => $actualites
        ]);
    }

    #[Route('/coalitions', name: 'app_coalitions')]
    public function coalitions(Request $request, EntityManagerInterface $entityManager): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        // Get filter parameters
        $region = $request->query->get('region');
        $domaine = $request->query->get('domaine');
        $search = $request->query->get('search');
        
        // Build query
        $qb = $entityManager->getRepository(Coalition::class)
            ->createQueryBuilder('c')
            ->orderBy('c.titre', 'ASC');
        
        if ($region) {
            $qb->andWhere('c.region = :region')
               ->setParameter('region', $region);
        }
        
        if ($domaine) {
            $qb->andWhere('c.domaine = :domaine')
               ->setParameter('domaine', $domaine);
        }
        
        if ($search) {
            $qb->andWhere('c.titre LIKE :search OR c.description LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }
        
        // Get total count for pagination
        $totalQuery = clone $qb;
        $total = $totalQuery->select('COUNT(c.id)')->getQuery()->getSingleScalarResult();
        
        // Get coalitions for current page
        $coalitions = $qb->setFirstResult($offset)
                          ->setMaxResults($limit)
                          ->getQuery()
                          ->getResult();
        
        // Calculate pagination info
        $totalPages = ceil($total / $limit);
        
        // Get filter options
        $regions = RegionEnum::getChoices();
        $domaines = ThemeEnum::getChoices();

        return $this->render('home/coalitions.html.twig', [
            'coalitions' => $coalitions,
            'regions' => $regions,
            'domaines' => $domaines,
            'current_region' => $region,
            'current_domaine' => $domaine,
            'current_search' => $search,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total' => $total
        ]);
    }

    #[Route('/coalition/{slug}', name: 'app_coalition_detail')]
    public function coalitionDetail(string $slug, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Coalition::class);
        $coalition = $repository->findOneBy(['slug' => $slug]);
        
        if (!$coalition) {
            throw $this->createNotFoundException('Coalition not found');
        }
        
        // Get related events
        $events = $entityManager->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->join('e.organizations', 'o')
            ->where('o.id = :coalitionId')
            ->setParameter('coalitionId', $coalition->getId())
            ->orderBy('e.dateDebut', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        
        // Get related opportunities (projects)
        $opportunities = $entityManager->getRepository(Opportunity::class)
            ->createQueryBuilder('op')
            ->where('op.organisme = :coalitionName OR op.organisme LIKE :coalitionSearch')
            ->setParameter('coalitionName', $coalition->getTitre())
            ->setParameter('coalitionSearch', '%' . $coalition->getTitre() . '%')
            ->orderBy('op.dateCreation', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        
        // Get related news (actualités)
        $actualites = $entityManager->getRepository(Actualite::class)
            ->createQueryBuilder('a')
            ->where('a.statut = :statut')
            ->andWhere('a.contenu LIKE :coalitionSearch OR a.titre LIKE :coalitionSearch')
            ->setParameter('statut', 'publié')
            ->setParameter('coalitionSearch', '%' . $coalition->getTitre() . '%')
            ->orderBy('a.datePublication', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        
        return $this->render('home/coalition_detail.html.twig', [
            'coalition' => $coalition,
            'events' => $events,
            'opportunities' => $opportunities,
            'actualites' => $actualites
        ]);
    }

    #[Route('/project/{slug}', name: 'app_project_detail')]
    public function projectDetail(string $slug, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Project::class);
        $project = $repository->findOneBy(['slug' => $slug]);
        
        if (!$project) {
            throw $this->createNotFoundException('Projet non trouvé');
        }
        
        return $this->render('home/project_detail.html.twig', [
            'project' => $project
        ]);
    }

    #[Route('/organization/{slug}/resources', name: 'app_organization_resources')]
    public function organizationResources(string $slug, EntityManagerInterface $entityManager): Response
    {
        $organization = $entityManager->getRepository(Organization::class)
            ->findOneBy(['slug' => $slug]);
        
        if (!$organization) {
            throw $this->createNotFoundException('Organisation non trouvée');
        }
        
        $resources = $entityManager->getRepository(Resource::class)
            ->findByOrganization($organization);
        
        return $this->render('home/organization_resources.html.twig', [
            'organization' => $organization,
            'resources' => $resources
        ]);
    }

    #[Route('/resource/{slug}', name: 'app_resource_detail')]
    public function resourceDetail(string $slug, EntityManagerInterface $entityManager): Response
    {
        $resource = $entityManager->getRepository(Resource::class)
            ->findOneBySlug($slug);
        
        if (!$resource) {
            throw $this->createNotFoundException('Ressource non trouvée');
        }
        
        // Get related resources from the same organization
        $relatedResources = $entityManager->getRepository(Resource::class)
            ->createQueryBuilder('r')
            ->where('r.organization = :organization')
            ->andWhere('r.id != :currentId')
            ->setParameter('organization', $resource->getOrganization())
            ->setParameter('currentId', $resource->getId())
            ->orderBy('r.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
        
        return $this->render('home/resource_detail.html.twig', [
            'resource' => $resource,
            'relatedResources' => $relatedResources
        ]);
    }
}