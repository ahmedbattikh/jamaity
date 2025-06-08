<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('pages/about.html.twig');
    }

    #[Route('/team', name: 'app_team')]
    public function team(): Response
    {
        return $this->render('pages/team.html.twig');
    }

    #[Route('/reports', name: 'app_reports')]
    public function reports(): Response
    {
        return $this->render('pages/reports.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('pages/contact.html.twig');
    }

    #[Route('/resources', name: 'app_resources')]
    public function resources(): Response
    {
        return $this->render('pages/resources.html.twig');
    }

    #[Route('/station47', name: 'app_station47')]
    public function station47(): Response
    {
        return $this->render('pages/station47.html.twig');
    }

    #[Route('/faq', name: 'app_faq')]
    public function faq(): Response
    {
        return $this->render('pages/faq.html.twig');
    }

    #[Route('/jamaity-tour', name: 'app_jamaity_tour')]
    public function jamaityTour(): Response
    {
        return $this->render('pages/jamaity_tour.html.twig');
    }

    #[Route('/projet-rose', name: 'app_projet_rose')]
    public function projetRose(): Response
    {
        return $this->render('pages/projet_rose.html.twig');
    }

    #[Route('/xchange', name: 'app_xchange')]
    public function xchange(): Response
    {
        return $this->render('pages/xchange.html.twig');
    }

    #[Route('/projet-iwatch', name: 'app_projet_iwatch')]
    public function projetIwatch(): Response
    {
        return $this->render('pages/projet_iwatch.html.twig');
    }

    #[Route('/jamaity-coordination', name: 'app_jamaity_coordination')]
    public function jamaityCoordination(): Response
    {
        return $this->render('pages/jamaity_coordination.html.twig');
    }

    #[Route('/dare-4-0', name: 'app_dare_4_0')]
    public function dare40(): Response
    {
        return $this->render('pages/dare_4_0.html.twig');
    }

    #[Route('/bladi', name: 'app_bladi')]
    public function bladi(): Response
    {
        return $this->render('pages/bladi.html.twig');
    }

    #[Route('/ambassadeurs', name: 'app_ambassadeurs')]
    public function ambassadeurs(): Response
    {
        return $this->render('pages/ambassadeurs.html.twig');
    }

    #[Route('/7oumti', name: 'app_7oumti')]
    public function sevenOumti(): Response
    {
        return $this->render('pages/7oumti.html.twig');
    }

    #[Route('/privacy', name: 'app_privacy')]
    public function privacy(): Response
    {
        return $this->render('pages/privacy.html.twig');
    }

    #[Route('/terms', name: 'app_terms')]
    public function terms(): Response
    {
        return $this->render('pages/terms.html.twig');
    }
}