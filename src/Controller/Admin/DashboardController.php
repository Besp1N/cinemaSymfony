<?php

namespace App\Controller\Admin;

use App\Entity\Cinema;
use App\Entity\Movie;
use App\Entity\MovieTheater;
use App\Entity\Reservation;
use App\Entity\Screening;
use App\Entity\Seat;
use App\Entity\User;
use App\Repository\CinemaRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class DashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $cinemaRepository = $this->entityManager->getRepository(Cinema::class);
        $cinemas = $cinemaRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'cinemas' => $cinemas,
        ]);
    }

    public function isAdmin(): bool
    {
        return $this->security->isGranted('ROLE_ADMIN');
    }



    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cinema');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('back to home', 'fas fa-arrow-left', 'app_home');
        yield MenuItem::linkToCrud('Movies', 'fas fa-list', Movie::class);
        yield MenuItem::linkToCrud('Movie Theaters', 'fas fa-list', MovieTheater::class);
        yield MenuItem::linkToCrud('Cinemas', "fas fa-list", Cinema::class);
        yield MenuItem::linkToCrud('Seats', 'fas fa-list', Seat::class);
        yield MenuItem::linkToCrud('Screening', "fas fa-list", Screening::class);
        yield MenuItem::linkToCrud('Reservation', "fas fa-list", Reservation::class);
        yield MenuItem::linkToCrud('users', 'fas fa-list', User::class);
    }


}
