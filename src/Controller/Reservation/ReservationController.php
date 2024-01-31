<?php

namespace App\Controller\Reservation;

use App\Controller\Services\AchievementsService;
use App\Controller\Services\ReservationAndAchievementService;
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
        $reservationAndAchievementService = new ReservationAndAchievementService($reservationRepository, $achievementsRepository, $seatRepository, $entityManager);
        $user = $this->getUser();

        $occupiedSeats = [];
        $seatsWithStatus = [];
        $reservationAndAchievementService->checkSeatStatus($occupiedSeats, $seatsWithStatus, $screening);

        if ($request->isMethod('POST') and $this->isCsrfTokenValid('reservation', $request->request->get('_token')) and $user instanceof \App\Entity\User)
        {
            $selectedSeatId = $request->request->get('selectedSeat');
            $reservationAndAchievementService->makeReservation($user, $selectedSeatId, $screening);
            $reservationAndAchievementService->checkAndGrantAchievement($user, $screening);
            $this->addFlash('success', 'zrobiles rezerwacje!');

            return $this->redirect($this->generateUrl('app_user', [
                        'user' => $user->getId()
                    ]).'#bookings');
        }

        return $this->render('reservation/index.html.twig', [

            'seats' => $seatsWithStatus,
            'screening' => $screening
        ]);
    }
}
