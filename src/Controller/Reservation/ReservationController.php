<?php

namespace App\Controller\Reservation;

use App\Controller\Services\AchievementsService;
use App\Controller\Services\ReservationService;
use App\Controller\Services\SeatStatusService;
use App\Entity\Reservation;
use App\Entity\Screening;
use App\Repository\AchievementsRepository;
use App\Repository\ReservationRepository;
use App\Repository\SeatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class ReservationController extends AbstractController
{
    #[Route('/reservation/{screening}', name: 'app_reservation', priority: 7)]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request , Screening $screening, SeatRepository $seatRepository, ReservationRepository $reservationRepository, AchievementsRepository $achievementsRepository ,EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $movieTheaterId = $screening->getMovieTheater()->getId();
        $seats = $seatRepository->findByMovieTheater($movieTheaterId);
        $reservations = $reservationRepository->findBy(['screening' => $screening]);

        $occupiedSeats = [];
        $seatsWithStatus = [];
        $seatService = new SeatStatusService();
        $seatService->checkSeatStatus($occupiedSeats, $seatsWithStatus, $reservations, $seats);

        // function to POST from form reservation. Uses 2 services helpers
        if ($request->isMethod('POST'))
        {
            $csrfToken = $request->request->get('_token');
            if (!$this->isCsrfTokenValid('reservation', $csrfToken)) {
                return new RedirectResponse('/');
            }

            $selectedSeatId = $request->request->get('selectedSeat');
            $reservation = new ReservationService($seatRepository, $entityManager);

            if ($user instanceof \App\Entity\User) {
                $reservation->makeReservation($user, $selectedSeatId, $screening);
                $achievementsService = new AchievementsService($reservationRepository, $achievementsRepository, $entityManager);
                $achievementsService->checkAndGrantAchievement($user, $screening);
                $this->addFlash('success', 'zrobiles rezerwacje!');

                return $this->redirect($this->generateUrl('app_user', [
                        'user' => $user->getId()
                    ]).'#bookings');
            } else {
                return new RedirectResponse('/');
            }
        }

        return $this->render('reservation/index.html.twig', [

            'seats' => $seatsWithStatus,
            'screening' => $screening
        ]);
    }
}
