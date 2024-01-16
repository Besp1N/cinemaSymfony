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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {

    }
    public function load(ObjectManager $manager): void
    {
        $user123 = new User();
        $user123->setName('John');
        $user123->setProfilePicture('dupa123');
        $user123->setLastname('Doe');
        $user123->setEmail('wielkitest@wp.pl');
        $user123->setCreatedAt(new \DateTimeImmutable());
        $user123->setRole('ROLE_USER');
        $user123->setPhoneNumber('123456789');
        $user123->setPassword($this->userPasswordHasher->hashPassword($user123, '12345678'));

//        $manager->persist($user123);
//        $manager->flush();
//
//        $user = new User();
//        $user->setName('Luke');
//        $user->setLastname('Skywalker');
//        $user->setEmail('elo@wp.pl');
//        $user->setPassword('ok');
//        $user->setCreatedAt(new DateTimeImmutable());
//        $user->setRole('User');
//        $user->setProfilePicture("test//test");
//        $user->setPhoneNumber("+48 123 456 789");

        // Tworzenie filmu
        $movie = new Movie();
        $movie->setTitle('Indiana Jones');
        $movie->setDescription('cool movie');
        $movie->setDirector('Steven Spielberg');
        $movie->setGenre('Adventure');
        $movie->setDuration(new DateTimeImmutable());
        $movie->setRating(9.0);
        $movie->setReleaseYear(new DateTime());
        $movie->setImage("images/poster1.jpg");

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
        $reservation->setUser($user123);
        $reservation->setSeat($seat);
        $reservation->setScreening($screening);

        // Dodawanie elementów do relacji
        $user123->addReservation($reservation);
        $movieTheater->addSeat($seat);
        $movieTheater->addScreening($screening);
        $cinema->addMovieTheater($movieTheater);

        // Persystencja obiektów do bazy danych
        $manager->persist($user123);
        $manager->persist($movie);
        $manager->persist($cinema);

        // Flush do zapisania zmian w bazie danych
        $manager->flush();

        $movie = new Movie();;
        $movie->setTitle('Star Wars');
        $movie->setDescription('cool movie');
        $movie->setDirector('George Lucas');
        $movie->setGenre('Sci-Fi');
        $movie->setDuration(new DateTimeImmutable());
        $movie->setReleaseYear(new DateTime());
        $movie->setImage("images/poster2.jpg");
        $movie->setRating(5.0);


        $adminUser = new User();
        $adminUser->setName('admin');
        $adminUser->setLastname('admin');
        $adminUser->setProfilePicture('dupa/dupa');
        $adminUser->setPassword($this->userPasswordHasher->hashPassword($adminUser, 'dupa'));
        $adminUser->setRole('ROLE_ADMIN');
        $adminUser->setCreatedAt(new DateTimeImmutable());
        $adminUser->setPhoneNumber('+48 123456789');
        $adminUser->setEmail('admin@admin.pl');

        $manager->persist($adminUser);
        $manager->flush();


        $manager->persist($movie);
        $manager->flush();







    }
}
