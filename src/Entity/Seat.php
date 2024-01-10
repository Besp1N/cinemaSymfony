<?php

namespace App\Entity;

use App\Repository\SeatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeatRepository::class)]
class Seat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'seats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MovieTheater $movie_theater = null;

    #[ORM\Column(length: 255)]
    private ?string $seat_row = null;

    #[ORM\Column(length: 255)]
    private ?string $seat_number = null;

    #[ORM\Column(length: 255)]
    private ?string $seat_type = null;

    #[ORM\OneToMany(mappedBy: 'seat', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieTheater(): ?MovieTheater
    {
        return $this->movie_theater;
    }

    public function setMovieTheater(?MovieTheater $movie_theater): static
    {
        $this->movie_theater = $movie_theater;

        return $this;
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

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setSeat($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getSeat() === $this) {
                $reservation->setSeat(null);
            }
        }

        return $this;
    }
}
