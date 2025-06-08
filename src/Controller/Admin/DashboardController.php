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

#[IsGranted('ROLE_ADMIN')]

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(AssociationCrudController::class)->generateUrl());
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