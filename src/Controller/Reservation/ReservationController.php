<?php

namespace App\Controller\Reservation;


use App\Controller\Services\ReservationAndAchievementService;

use App\Entity\Screening;
use App\Entity\User;
use App\Repository\AchievementsRepository;
use App\Repository\ReservationRepository;
use App\Repository\SeatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class ReservationController extends AbstractController
{
    #[Route('/reservation/{screening}', name: 'app_reservation', priority: 7)]
    #[IsGranted('ROLE_USER')]
    public function index(
        Request $request,
        Screening $screening,
        SeatRepository $seatRepository,
        ReservationRepository $reservationRepository,
        AchievementsRepository $achievementsRepository,
        EntityManagerInterface $entityManager,
        ReservationAndAchievementService $reservationAndAchievementService): Response {


        /*
         * Those two arrays are passed to checkSeatStatus by reference.
         * Because of reference it's automatically set up
         */
        $occupiedSeats = [];
        $seatsWithStatus = [];
        $reservationAndAchievementService->checkSeatStatus($occupiedSeats, $seatsWithStatus, $screening);

        /*
         * Post request means that someone has submitted the reservation form
         * if condition is true it makes reservation and checks achievement,
         * at last it redirects to user profile - bookings section
         */

        $user = $this->getUser();

        if ($request->isMethod('POST') and
            $this->isCsrfTokenValid('reservation', $request->request->get('_token')) and
            $user instanceof User) {
                $selectedSeatId = $request->request->get('selectedSeat');
                $reservationAndAchievementService->makeReservation($user, $selectedSeatId, $screening);
                $reservationAndAchievementService->checkAndGrantAchievement($user, $screening);
                $this->addFlash('success', 'zrobiles rezerwacje!');

                return $this->redirect($this->generateUrl('app_user', [
                    'user' => $user->getId()]).'#bookings');
        }

        /*
         * By default this controller returns reservation view.
         */
        return $this->render('reservation/index.html.twig', [

            'seats' => $seatsWithStatus,
            'screening' => $screening
        ]);
    }
}
