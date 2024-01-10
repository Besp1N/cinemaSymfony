<?php

namespace App\Entity;

use App\Repository\CinemaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CinemaRepository::class)]
class Cinema
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\OneToMany(mappedBy: 'cinema', targetEntity: MovieTheater::class, cascade: ["persist"])]
    private Collection $movieTheaters;

    public function __construct()
    {
        $this->movieTheaters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, MovieTheater>
     */
    public function getMovieTheaters(): Collection
    {
        return $this->movieTheaters;
    }

    public function addMovieTheater(MovieTheater $movieTheater): static
    {
        if (!$this->movieTheaters->contains($movieTheater)) {
            $this->movieTheaters->add($movieTheater);
            $movieTheater->setCinema($this);
        }

        return $this;
    }

    public function removeMovieTheater(MovieTheater $movieTheater): static
    {
        if ($this->movieTheaters->removeElement($movieTheater)) {
            // set the owning side to null (unless already changed)
            if ($movieTheater->getCinema() === $this) {
                $movieTheater->setCinema(null);
            }
        }

        return $this;
    }
}
