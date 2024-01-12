<?php

namespace App\Entity;

use App\Repository\MovieTheaterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieTheaterRepository::class)]
class MovieTheater
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'movieTheaters')]
    private ?Cinema $cinema = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'movie_theater', targetEntity: Seat::class)]
    private Collection $seats;

    #[ORM\OneToMany(mappedBy: 'movie_theater', targetEntity: Screening::class)]
    private Collection $screenings;

    public function __construct()
    {
        $this->seats = new ArrayCollection();
        $this->screenings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCinema(): ?Cinema
    {
        return $this->cinema;
    }

    public function setCinema(?Cinema $cinema): static
    {
        $this->cinema = $cinema;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Seat>
     */
    public function getSeats(): Collection
    {
        return $this->seats;
    }

    public function addSeat(Seat $seat): static
    {
        if (!$this->seats->contains($seat)) {
            $this->seats->add($seat);
            $seat->setMovieTheater($this);
        }

        return $this;
    }

    public function removeSeat(Seat $seat): static
    {
        if ($this->seats->removeElement($seat)) {
            // set the owning side to null (unless already changed)
            if ($seat->getMovieTheater() === $this) {
                $seat->setMovieTheater(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Screening>
     */
    public function getScreenings(): Collection
    {
        return $this->screenings;
    }

    public function addScreening(Screening $screening): static
    {
        if (!$this->screenings->contains($screening)) {
            $this->screenings->add($screening);
            $screening->setMovieTheater($this);
        }

        return $this;
    }

    public function removeScreening(Screening $screening): static
    {
        if ($this->screenings->removeElement($screening)) {
            // set the owning side to null (unless already changed)
            if ($screening->getMovieTheater() === $this) {
                $screening->setMovieTheater(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
