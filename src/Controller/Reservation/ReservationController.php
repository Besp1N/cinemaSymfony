<?php

namespace App\Controller\Reservation;

use App\Entity\Reservation;
use App\Entity\Screening;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\SeatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{screening}', name: 'app_reservation', priority: 7)]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request , Screening $screening, SeatRepository $seatRepository, ReservationRepository $reservationRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $movieTheaterId = $screening->getMovieTheater()->getId();
        $seats = $seatRepository->findByMovieTheater($movieTheaterId);

        $reservations = $reservationRepository->findBy(['screening' => $screening]);

        // iteruje se po rezerwacjach gdzie indexy sa id siedzien i ustawiam je na true
        $occupiedSeats = [];
        foreach ($reservations as $reservation) {
            $occupiedSeats[$reservation->getSeat()->getId()] = true;
        }

        $seatsWithStatus = [];
        foreach ($seats as $seat) {
            $seatId = $seat->getId();
            $status = isset($occupiedSeats[$seatId]) ? 'taken' : 'available';
            $seatsWithStatus[] = ['seat' => $seat, 'status' => $status];
        }


        if ($request->isMethod('POST')) {
            $csrfToken = $request->request->get('_token');
            if (!$this->isCsrfTokenValid('reservation', $csrfToken)) {
                return new Response('chuj');
            }
            $selectedSeatId = $request->request->get('selectedSeat');
            $selectedSeat = $seatRepository->find($selectedSeatId);
            $reservation = new Reservation();
            $reservation->setSeat($selectedSeat);
            $reservation->setUser($user);
            $reservation->setScreening($screening);
            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'zrobiles rezerwacje!');
            return $this->redirectToRoute('app_user', [
                'user' => $user->getId()
            ]);
        }

        return $this->render('reservation/index.html.twig', [

            'seats' => $seatsWithStatus,
            'screening' => $screening
        ]);
    }
}
