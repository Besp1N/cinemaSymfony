<?php

namespace App\Controller\Services;

use App\Entity\User;
use App\Repository\AchievementsRepository;
use App\Repository\ReservationRepository;
use App\Entity\Screening;
use App\Entity\UserAchievements;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Yaml\Yaml;

class AchievementsService
{
    private ReservationRepository $reservationRepository;
    private AchievementsRepository $achievementsRepository;
    private EntityManagerInterface $entityManager;
    private array $achievementConfig;

    public function __construct(ReservationRepository $reservationRepository, AchievementsRepository $achievementsRepository, EntityManagerInterface $entityManager)
    {
        $this->reservationRepository = $reservationRepository;
        $this->achievementsRepository = $achievementsRepository;
        $this->entityManager = $entityManager;
        $this->loadAchievementConfig();
    }

    public function checkAndGrantAchievement(User $user, Screening $screening): void
    {
        $genre = $screening->getMovie()->getGenre();
        $userReservations = $this->reservationRepository->countUserReservationsByGenre($user->getId(), $genre);
        $userReservationsCount = count($userReservations);

        foreach ($this->achievementConfig['achievements'] as $achievement) {
            if (isset($achievement['genre'], $achievement['required_reservations']) && $achievement['genre'] === $genre && $userReservationsCount == $achievement['required_reservations']) {
                $this->grantAchievement($user, $genre);
            }
        }

    }

    private function grantAchievement(User $user, string $genre): void
    {
        $achievement = $this->achievementsRepository->findOneBy(['genre' => $genre]);
        $userAchievement = new UserAchievements();
        $userAchievement->setUser($user);
        $userAchievement->setAchievement($achievement);
        $this->entityManager->persist($userAchievement);
        $this->entityManager->flush();
    }

    private function loadAchievementConfig(): void
    {
        $configPath = $this->getProjectDir() . '/config/achievements.yaml';
        $this->achievementConfig = Yaml::parseFile($configPath);
    }

    private function getProjectDir(): string
    {
        // Zwróć ścieżkę do katalogu projektu
        return dirname(__DIR__, 3);
    }
}
