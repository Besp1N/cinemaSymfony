<?php

namespace App\Controller\Admin;

use App\Entity\Cinema;
use App\Entity\Movie;
use App\Entity\MovieTheater;
use App\Entity\Screening;
use App\Entity\Seat;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render("admin/index.html.twig");
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cinema');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Movies', 'fas fa-list', Movie::class);
        yield MenuItem::linkToCrud('Movie Theaters', 'fas fa-list', MovieTheater::class);
        yield MenuItem::linkToCrud('Cinemas', "fas fa-list", Cinema::class);
        yield MenuItem::linkToCrud('Seats', 'fas fa-list', Seat::class);
        yield MenuItem::linkToCrud('Screening', "fas fa-list", Screening::class);
    }
}
