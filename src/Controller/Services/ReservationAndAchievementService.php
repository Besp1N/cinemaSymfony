<?php

namespace App\Controller\Services;

use App\Entity\Reservation;
use App\Entity\Screening;
use App\Entity\User;
use App\Entity\UserAchievements;
use App\Repository\AchievementsRepository;
use App\Repository\ReservationRepository;
use App\Repository\SeatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Yaml\Yaml;

class ReservationAndAchievementService
{
    private ReservationRepository $reservationRepository;
    private AchievementsRepository $achievementsRepository;
    private EntityManagerInterface $entityManager;
    private SeatRepository $seatRepository;
    private array $achievementConfig;

    /*
     * Set up all data from ReservationController to use it in functions
     */
    public function __construct(
        ReservationRepository $reservationRepository,
        AchievementsRepository $achievementsRepository,
        SeatRepository $seatRepository,
        EntityManagerInterface $entityManager) {

            $this->reservationRepository = $reservationRepository;
            $this->achievementsRepository = $achievementsRepository;
            $this->entityManager = $entityManager;
            $this->seatRepository = $seatRepository;
            $this->loadAchievementConfig();
    }

    /*
     * checkSeatStatus function sets up 2 arrays by reference,
     * It checks if seat is taken or available
     */
    public function checkSeatStatus(array &$occupiedSeats, array &$seatsWithStatus, Screening $screening): void
    {
        $movieTheaterId = $screening->getMovieTheater()->getId();
        $seats = $this->seatRepository->findByMovieTheater($movieTheaterId);
        $reservations = $this->reservationRepository->findBy(['screening' => $screening]);

        foreach ($reservations as $reservation) {
            $occupiedSeats[$reservation->getSeat()->getId()] = true;
        }

        foreach ($seats as $seat) {
            $seatId = $seat->getId();
            $status = isset($occupiedSeats[$seatId]) ? 'taken' : 'available';
            $seatsWithStatus[] = ['seat' => $seat, 'status' => $status];
        }
    }

    /*
     * makeReservation function just makes a new Reservation object and prepares it to flush to database.
     */
    public function makeReservation(User $user, int $selectedSeatId, Screening $screening): void
    {
        $selectedSeat = $this->seatRepository->find($selectedSeatId);
        $reservation = new Reservation();
        $reservation->setSeat($selectedSeat);
        $reservation->setUser($user);
        $reservation->setScreening($screening);
        $this->entityManager->persist($reservation);
        $this->entityManager->flush();
    }

    /*
     * checkAndGrantAchievement function gets user reservations from
     * reservation repository form own ORM function - ( countUserReservationsByGenre )
     * countUserReservationsByGenre return an array, then I count how much records are in array.
     * At last the foreach loop checks the achievement by genre and by required_reservations to get achievement
     * if all condition is true User gets and achievement via grantAchievement function
     */
    public function checkAndGrantAchievement(User $user, Screening $screening): void
    {
        $genre = $screening->getMovie()->getGenre();
        $userReservations = $this->reservationRepository->countUserReservationsByGenre($user->getId(), $genre);
        $userReservationsCount = count($userReservations);

        foreach ($this->achievementConfig['achievements'] as $achievement) {
            if (
                isset($achievement['genre'], $achievement['required_reservations']) &&
                $achievement['genre'] === $genre &&
                $userReservationsCount == $achievement['required_reservations']) {

                $this->grantAchievement($user, $genre);
            }
        }

    }

    /*
     * grantAchievement function finds achievement by genre and
     * flushes userAchievement to database
     */
    private function grantAchievement(User $user, string $genre): void
    {
        $achievement = $this->achievementsRepository->findOneBy(['genre' => $genre]);
        $userAchievement = new UserAchievements();
        $userAchievement->setUser($user);
        $userAchievement->setAchievement($achievement);
        $this->entityManager->persist($userAchievement);
        $this->entityManager->flush();
    }

    /*
     * loadAchievementConfig - load config from achievements.yaml
     * There are all requirements to get achievement.
     * gerProjectDir function helps to obtain right path
     */
    private function loadAchievementConfig(): void
    {
        $configPath = $this->getProjectDir() . '/config/achievements.yaml';
        $this->achievementConfig = Yaml::parseFile($configPath);
    }

    private function getProjectDir(): string
    {
        return dirname(__DIR__, 3);
    }
}
