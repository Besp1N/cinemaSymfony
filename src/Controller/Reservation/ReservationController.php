<?php

namespace App\Controller\Reservation;

use App\Entity\Screening;
use App\Repository\SeatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{screening}', name: 'app_reservation', priority: 7)]
    public function index(Screening $screening, SeatRepository $seatRepository): Response
    {
        $user = $this->getUser();
        $movieTheaterId = $screening->getMovieTheater()->getId();
        $seats = $seatRepository->findByMovieTheater($movieTheaterId);







        return $this->render('reservation/index.html.twig', [
            'seats' => $seats,
            'movie' => $screening->getMovie()
        ]);
    }
}
