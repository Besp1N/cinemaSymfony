<?php

namespace App\Controller\Reservation;

use App\Entity\Screening;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{screening}', name: 'app_reservation', priority: 7)]
    public function index(Screening $screening): Response
    {
        dd($screening->getMovieTheater()->getCinema());
        return $this->render('reservation/index.html.twig');
    }
}
