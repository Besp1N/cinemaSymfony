<?php

namespace App\Controller\Reservation;

use App\Entity\Reservation;
use App\Entity\Screening;
use App\Entity\UserAchievements;
use App\Form\ReservationType;
use App\Repository\AchievementsRepository;
use App\Repository\ReservationRepository;
use App\Repository\SeatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReservationController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[Route('/reservation/{screening}', name: 'app_reservation', priority: 7)]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request , Screening $screening, SeatRepository $seatRepository, ReservationRepository $reservationRepository, AchievementsRepository $achievementsRepository ,EntityManagerInterface $entityManager): Response
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

            $genre = $screening->getMovie()->getGenre();
            $userReservations = $reservationRepository->countUserReservationsByGenre($user->getId(), $genre);
            $userReservationsCount = count($userReservations);

            // na pozniej - wywalic cialo if do funkcji bo burder bedzie albo zamienic if na switch
            if ($genre == "Drama" and $userReservationsCount == 2) {
                $achievement = $achievementsRepository->findOneBy(['genre' => $genre]);
                $userAchievement = new UserAchievements();
                $userAchievement->setUser($user);
                $userAchievement->setAchievement($achievement);
                $entityManager->persist($userAchievement);
                $entityManager->flush();
            }
            elseif ($genre = "Science Fiction" and $userReservationsCount == 2) {
                $achievement = $achievementsRepository->findOneBy(['genre' => $genre]);
                $userAchievement = new UserAchievements();
                $userAchievement->setUser($user);
                $userAchievement->setAchievement($achievement);
                $entityManager->persist($userAchievement);
                $entityManager->flush();
            }


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
