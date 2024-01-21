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
        $user123->setRoles(['ROLE_USER']);
        $user123->setPhoneNumber('123456789');
        $user123->setPassword($this->userPasswordHasher->hashPassword($user123, '12345678'));
        $user123->setBio("TWOJA STARA");

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
        $cinema->setCoords('53.123,18.000');

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
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setCreatedAt(new DateTimeImmutable());
        $adminUser->setPhoneNumber('+48 123456789');
        $adminUser->setEmail('admin@admin.pl');
        $adminUser->setBio('DUPA');

        $manager->persist($adminUser);
        $manager->flush();


        $manager->persist($movie);
        function createSeatsForTheater($manager,MovieTheater $theater, $rows, $seatsPerRow, $seatType) {
            foreach (range('A', chr(ord('A') + $rows - 1)) as $row) {
                for ($number = 1; $number <= $seatsPerRow; $number++) {
                    $seat = new Seat();
                    $seat->setSeatRow($row);
                    $seat->setSeatNumber((string)$number);
                    $seat->setSeatType($seatType); // Assuming seat type is uniform for simplicity
                    $theater->addSeat($seat);
                    $manager->persist($seat);
                }
            }
        }

        // Creating multiple cinemas and theaters
        $cinemas = [];
        for ($i = 1; $i <= 3; $i++) {
            $cinema = new Cinema();
            $cinema->setName("Cinema $i");
            $cinema->setCity("City $i");
            $cinema->setAddress("Address $i");
            $cinema->setCoords('Coords $i');

            $movieTheater = new MovieTheater();
            $movieTheater->setName("Theater $i");

            // Create seats for each theater
            createSeatsForTheater($manager, $movieTheater, 10, 15, 'Standard'); // Example: 10 rows, 15 seats per row

            $cinema->addMovieTheater($movieTheater);
            $manager->persist($cinema);
            $manager->persist($movieTheater);

            $cinemas[] = $cinema;
        }

        // Persists and flushes for each cinema
        foreach ($cinemas as $cinema) {
            $manager->persist($cinema);
            foreach ($cinema->getMovieTheaters() as $theater) {
                foreach ($theater->getSeats() as $seat) {
                    $manager->persist($seat);
                }
            }
        }

        $cinema1 = $cinemas[0]; // Assuming $cinemas is the array holding the cinema entities
        $theater1 = $cinema1->getMovieTheaters()[0]; // Assuming getMovieTheaters() returns an array or a Collection

        // Create additional movies
        $movies = [
            ['title' => 'The Matrix', 'description' => 'Sci-fi classic', 'director' => 'The Wachowskis', 'genre' => 'Sci-Fi', 'image' => 'images/matrix.jpg', 'rating' => 8.7],
            ['title' => 'Inception', 'description' => 'Dream within a dream', 'director' => 'Christopher Nolan', 'genre' => 'Action', 'image' => 'images/inception.jpg', 'rating' => 8.8],
            // ... add as many as you like
        ];

        foreach ($movies as $movieData) {
            $movie = new Movie();
            $movie->setTitle($movieData['title']);
            $movie->setDescription($movieData['description']);
            $movie->setDirector($movieData['director']);
            $movie->setGenre($movieData['genre']);
            $movie->setDuration(new DateTimeImmutable());
            $movie->setReleaseYear(new DateTime());
            $movie->setImage($movieData['image']);
            $movie->setRating($movieData['rating']);

            $manager->persist($movie);

            // Create a screening for each movie
            $screening = new Screening();
            $screening->setMovie($movie);
            $screening->setStartTime(new DateTimeImmutable('next Saturday 8pm')); // Example start time, adjust as needed

            // Associate the screening with Theater 1 in Cinema 1
            $theater1->addScreening($screening);
            $manager->persist($screening);
        }

        // Persisting the updated theater and cinema
        $manager->persist($theater1);
        $manager->persist($cinema1);

        // Flush to save changes to the database
        $manager->flush();






    }
}
