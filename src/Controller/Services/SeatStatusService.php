<?php

namespace App\Controller\Services;

class SeatStatusService
{
    public function checkSeatStatus(array &$occupiedSeats, array &$seatsWithStatus, array $reservations, array $seats): void
    {
        foreach ($reservations as $reservation) {
            $occupiedSeats[$reservation->getSeat()->getId()] = true;
        }

        foreach ($seats as $seat) {
            $seatId = $seat->getId();
            $status = isset($occupiedSeats[$seatId]) ? 'taken' : 'available';
            $seatsWithStatus[] = ['seat' => $seat, 'status' => $status];
        }
    }
}