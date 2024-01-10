<?php

namespace App\Entity;

use App\Repository\MovieTheatersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieTheatersRepository::class)]
class MovieTheaters
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'movieTheaters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cinema $cinema_id = null;

    #[ORM\OneToMany(mappedBy: 'move_theater_id', targetEntity: Seat::class, cascade: ["persist", "remove"])]
    private Collection $seats;

    public function __construct()
    {
        $this->seats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCinemaId(): ?Cinema
    {
        return $this->cinema_id;
    }

    public function setCinemaId(?Cinema $cinema_id): static
    {
        $this->cinema_id = $cinema_id;

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
            $seat->setMoveTheaterId($this);
        }

        return $this;
    }

    public function removeSeat(Seat $seat): static
    {
        if ($this->seats->removeElement($seat)) {
            // set the owning side to null (unless already changed)
            if ($seat->getMoveTheaterId() === $this) {
                $seat->setMoveTheaterId(null);
            }
        }

        return $this;
    }
}
