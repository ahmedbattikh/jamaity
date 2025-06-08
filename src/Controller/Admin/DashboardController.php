<?php

namespace App\Controller\Admin;

use App\Entity\Actualite;
use App\Entity\Association;
use App\Entity\Coalition;
use App\Entity\Event;
use App\Entity\Expert;
use App\Entity\Opportunity;
use App\Entity\Project;
use App\Entity\Ptf;
use App\Entity\Resource;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

#[IsGranted('ROLE_ADMIN')]

class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Get statistics for dashboard
        $associationsCount = $this->entityManager->getRepository(Association::class)
            ->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $ptfsCount = $this->entityManager->getRepository(Ptf::class)
            ->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $coalitionsCount = $this->entityManager->getRepository(Coalition::class)
            ->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $projectsCount = $this->entityManager->getRepository(Project::class)
            ->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $expertsCount = $this->entityManager->getRepository(Expert::class)
            ->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $eventsCount = $this->entityManager->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $opportunitiesCount = $this->entityManager->getRepository(Opportunity::class)
            ->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $resourcesCount = $this->entityManager->getRepository(Resource::class)
            ->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $actualitesCount = $this->entityManager->getRepository(Actualite::class)
            ->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // Get recent activities
        $recentAssociations = $this->entityManager->getRepository(Association::class)
            ->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        $recentEvents = $this->entityManager->getRepository(Event::class)
            ->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        $recentExperts = $this->entityManager->getRepository(Expert::class)
            ->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        return $this->render('admin/dashboard.html.twig', [
            'statistics' => [
                'associations' => $associationsCount,
                'ptfs' => $ptfsCount,
                'coalitions' => $coalitionsCount,
                'projects' => $projectsCount,
                'experts' => $expertsCount,
                'events' => $eventsCount,
                'opportunities' => $opportunitiesCount,
                'resources' => $resourcesCount,
                'actualites' => $actualitesCount,
            ],
            'recent_activities' => [
                'associations' => $recentAssociations,
                'events' => $recentEvents,
                'experts' => $recentExperts,
            ]
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // This method can be blank - it will be intercepted by the logout key on your firewall.
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/assets/img/logo.png" alt="Jamaity" height="40">')
            ->setFaviconPath('favicon.ico')
            ->setTranslationDomain('admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Actualités', 'fas fa-newspaper', Actualite::class);
        yield MenuItem::linkToCrud('Associations', 'fas fa-users', Association::class);
        yield MenuItem::linkToCrud('Coalitions', 'fas fa-handshake', Coalition::class);
        yield MenuItem::linkToCrud('PTFs', 'fas fa-project-diagram', Ptf::class);
        yield MenuItem::linkToCrud('Experts', 'fas fa-user-tie', Expert::class);
        yield MenuItem::linkToCrud('Events', 'fas fa-calendar', Event::class);
        yield MenuItem::linkToCrud('Opportunities', 'fas fa-briefcase', Opportunity::class);
        yield MenuItem::linkToCrud('Projects', 'fas fa-project-diagram', Project::class);
        yield MenuItem::linkToCrud('Resources', 'fas fa-file-alt', Resource::class);
        yield MenuItem::linkToLogout('Logout', 'fa fa-exit');
    }
}