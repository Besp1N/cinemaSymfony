<?php

namespace App\Entity;

use App\Repository\MovieTheatersRepository;
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
}
