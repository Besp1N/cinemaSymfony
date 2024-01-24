<?php

namespace App\Entity;

use App\Repository\UserAchievementsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserAchievementsRepository::class)]
class UserAchievements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userAchievements')]
    private ?User $user = null;

    #[ORM\ManyToOne]
    private ?Achievements $achievement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getAchievement(): ?Achievements
    {
        return $this->achievement;
    }

    public function setAchievement(?Achievements $achievement): static
    {
        $this->achievement = $achievement;

        return $this;
    }
}
