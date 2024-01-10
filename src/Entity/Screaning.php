<?php

namespace App\Entity;

use App\Repository\ScreaningRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScreaningRepository::class)]
class Screaning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_time = null;

    #[ORM\ManyToOne(inversedBy: 'screanings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MovieTheaters $movie_theater = null;

    #[ORM\ManyToOne(cascade: ["persist", "remove"], inversedBy: 'screanings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Movie $movie = null;

    #[ORM\ManyToOne(cascade: ["persist", "remove"], inversedBy: 'screaning')]
    private ?Reservation $reservation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): static
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getMovieTheater(): ?MovieTheaters
    {
        return $this->movie_theater;
    }

    public function setMovieTheater(?MovieTheaters $movie_theater): static
    {
        $this->movie_theater = $movie_theater;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): static
    {
        $this->movie = $movie;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }
}
