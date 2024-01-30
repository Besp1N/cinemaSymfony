<?php

namespace App\Controller\Services;

use App\Entity\Reservation;
use App\Entity\Screening;
use App\Entity\Seat;
use App\Entity\User;
use App\Repository\SeatRepository;
use Doctrine\ORM\EntityManagerInterface;

class ReservationService
{
    private SeatRepository $seatRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(SeatRepository $seatRepository, EntityManagerInterface $entityManager)
    {
        $this->seatRepository = $seatRepository;
        $this->entityManager = $entityManager;
    }
    public function makeReservation(User $user, int $selectedSeatId, Screening $screening): void
    {
        $selectedSeat = $this->seatRepository->find($selectedSeatId);
        $reservation = new Reservation();
        $reservation->setSeat($selectedSeat);
        $reservation->setUser($user);
        $reservation->setScreening($screening);
        $this->entityManager->persist($reservation);
        $this->entityManager->flush();
    }
}