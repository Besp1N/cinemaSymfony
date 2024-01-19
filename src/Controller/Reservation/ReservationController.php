<?php

namespace App\Controller\Reservation;

use App\Entity\Reservation;
use App\Entity\Screening;
use App\Repository\SeatRepository;
use Doctrine\ORM\EntityManagerInterface;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{screening}', name: 'app_reservation', priority: 7)]
    public function index(Request $request , Screening $screening, SeatRepository $seatRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $movieTheaterId = $screening->getMovieTheater()->getId();
        $seats = $seatRepository->findByMovieTheater($movieTheaterId);

        // bardzo dobra radziecka metoda, a co lepsze to nawet dziala
        // a bez jaj to musze zrobic ReservationType form i z niej to brac ale juz na dzisiaj tak bedzie

        if ($request->isMethod('POST')) {
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
            'seats' => $seats,
            'screening' => $screening
        ]);
    }
}
