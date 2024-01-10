<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $duration = null;

    #[ORM\Column(length: 500)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column]
    private ?int $relase_year = null;

    #[ORM\Column(length: 255)]
    private ?string $director = null;

    #[ORM\Column]
    private ?float $rating = null;

    #[ORM\Column(length: 600, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Screaning::class, cascade: ["persist", "remove"])]
    private Collection $screanings;

    public function __construct()
    {
        $this->screanings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getRelaseYear(): ?int
    {
        return $this->relase_year;
    }

    public function setRelaseYear(int $relase_year): static
    {
        $this->relase_year = $relase_year;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): static
    {
        $this->director = $director;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Screaning>
     */
    public function getScreanings(): Collection
    {
        return $this->screanings;
    }

    public function addScreaning(Screaning $screaning): static
    {
        if (!$this->screanings->contains($screaning)) {
            $this->screanings->add($screaning);
            $screaning->setMovie($this);
        }

        return $this;
    }

    public function removeScreaning(Screaning $screaning): static
    {
        if ($this->screanings->removeElement($screaning)) {
            // set the owning side to null (unless already changed)
            if ($screaning->getMovie() === $this) {
                $screaning->setMovie(null);
            }
        }

        return $this;
    }
}
