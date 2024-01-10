<?php

namespace App\Entity;

use App\Repository\SeatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeatRepository::class)]
class Seat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $seat_row = null;

    #[ORM\Column(length: 255)]
    private ?string $seat_number = null;

    #[ORM\Column(length: 255)]
    private ?string $seat_type = null;

    #[ORM\ManyToOne(inversedBy: 'seats')]
    private ?MovieTheaters $move_theater_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeatRow(): ?string
    {
        return $this->seat_row;
    }

    public function setSeatRow(string $seat_row): static
    {
        $this->seat_row = $seat_row;

        return $this;
    }

    public function getSeatNumber(): ?string
    {
        return $this->seat_number;
    }

    public function setSeatNumber(string $seat_number): static
    {
        $this->seat_number = $seat_number;

        return $this;
    }

    public function getSeatType(): ?string
    {
        return $this->seat_type;
    }

    public function setSeatType(string $seat_type): static
    {
        $this->seat_type = $seat_type;

        return $this;
    }

    public function getMoveTheaterId(): ?MovieTheaters
    {
        return $this->move_theater_id;
    }

    public function setMoveTheaterId(?MovieTheaters $move_theater_id): static
    {
        $this->move_theater_id = $move_theater_id;

        return $this;
    }
}
