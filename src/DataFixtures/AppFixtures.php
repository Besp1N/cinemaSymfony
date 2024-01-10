<?php

namespace App\DataFixtures;

use App\Entity\Cinema;
use App\Entity\Movie;
use App\Entity\MovieTheater;
use App\Entity\Reservation;
use App\Entity\Screening;
use App\Entity\Seat;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName('Luke');
        $user->setLastname('Skywalker');
        $user->setEmail('elo@wp.pl');
        $user->setPassword('ok');
        $user->setCreatedAt(new DateTimeImmutable());
        $user->setRole('User');
        $user->setProfilePicture("test//test");
        $user->setPhoneNumber("+48 123 456 789");

        // Tworzenie filmu
        $movie = new Movie();
        $movie->setTitle('Indiana Jones');
        $movie->setDescription('cool movie');
        $movie->setDirector('Steven Spielberg');
        $movie->setGenre('Adventure');
        $movie->setDuration(new DateTimeImmutable());
        $movie->setRating(9.0);
        $movie->setRelaseYear(new DateTime());
        $movie->setImage("test//test");

        // Tworzenie kina
        $cinema = new Cinema();
        $cinema->setName("Multikino");
        $cinema->setCity("Warszawa");
        $cinema->setAddress("zielona 1");

        // Tworzenie sali kinowej
        $movieTheater = new MovieTheater();
        $movieTheater->setName("Sala 1");

        // Tworzenie miejsca (siedzenia) w sali kinowej
        $seat = new Seat();
        $seat->setSeatRow("A");
        $seat->setSeatNumber("1");
        $seat->setSeatType("Vip");

        // Dodawanie filmu do seansu
        $screening = new Screening();
        $screening->setMovie($movie);
        $screening->setStartTime(new DateTimeImmutable());

        // Tworzenie rezerwacji dla użytkownika, miejsca i seansu
        $reservation = new Reservation();
        $reservation->setUser($user);
        $reservation->setSeat($seat);
        $reservation->setScreening($screening);

        // Dodawanie elementów do relacji
        $user->addReservation($reservation);
        $movieTheater->addSeat($seat);
        $movieTheater->addScreening($screening);
        $cinema->addMovieTheater($movieTheater);

        // Persystencja obiektów do bazy danych
        $manager->persist($user);
        $manager->persist($movie);
        $manager->persist($cinema);

        // Flush do zapisania zmian w bazie danych
        $manager->flush();


    }
}
