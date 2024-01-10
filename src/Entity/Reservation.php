<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: User::class, cascade: ["persist", "remove"])]
    private Collection $user;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seat $seat = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: Screaning::class)]
    private Collection $screaning;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->screaning = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setReservation($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getReservation() === $this) {
                $user->setReservation(null);
            }
        }

        return $this;
    }

    public function getSeat(): ?Seat
    {
        return $this->seat;
    }

    public function setSeat(?Seat $seat): static
    {
        $this->seat = $seat;

        return $this;
    }

    /**
     * @return Collection<int, Screaning>
     */
    public function getScreaning(): Collection
    {
        return $this->screaning;
    }

    public function addScreaning(Screaning $screaning): static
    {
        if (!$this->screaning->contains($screaning)) {
            $this->screaning->add($screaning);
            $screaning->setReservation($this);
        }

        return $this;
    }

    public function removeScreaning(Screaning $screaning): static
    {
        if ($this->screaning->removeElement($screaning)) {
            // set the owning side to null (unless already changed)
            if ($screaning->getReservation() === $this) {
                $screaning->setReservation(null);
            }
        }

        return $this;
    }
}
