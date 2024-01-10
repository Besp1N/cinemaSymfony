<?php

namespace App\DataFixtures;

use App\Entity\Cinema;
use App\Entity\Movie;
use App\Entity\MovieTheaters;
use App\Entity\Reservation;
use App\Entity\Screaning;
use App\Entity\Seat;
use App\Entity\Test;
use App\Entity\User;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $cinema = new Cinema();
        $cinema->setName("multikino");
        $cinema->setCity("slupsk");
        $cinema->setAddress("zielona4");

        $movieTheater1 = new MovieTheaters();
        $movieTheater1->setName("sala1");
        $movieTheater2 = new MovieTheaters();
        $movieTheater2->setName("sala2");

        $seat1 = new Seat();
        $seat1->setSeatType("vip");
        $seat1->setSeatRow("A");
        $seat1->setSeatNumber("7");
        $seat2 = new Seat();
        $seat2->setSeatType("vip");
        $seat2->setSeatRow("B");
        $seat2->setSeatNumber("8");

        $movieTheater1->addSeat($seat1);
        $movieTheater2->addSeat($seat2);

        $movie1 = new Movie();
        $movie1->setTitle("Indiana Jones");
        $movie1->setDescription("hit nad hity");
        $movie1->setDirector("Steven Spielberg");
        $movie1->setGenre("advanture");
        $movie1->setDuration(new DateTime());
        $movie1->setRating(5.0);
        $movie1->setRelaseYear(1980);

        $user1 = new User();
        $user1->setName("Luke");
        $user1->setLastname("Skywalker");
        $user1->setEmail("elo@wp.pl");
        $user1->setPassword("ok");
        $user1->setCreatedAt(new DateTimeImmutable());
        $user1->setPhoneNumber("+48 123 456 789");
        $user1->setRole("User");

        $reservation1 = new Reservation();
        $reservation1->setSeat($seat1);
        $reservation1->addUser($user1);


        $screaning1 = new Screaning();
        $screaning1->setMovie($movie1);
        $screaning1->setMovieTheater($movieTheater1);
        $screaning1->setStartTime(new DateTime());

        $screaning1->setReservation($reservation1);

        $movieTheater1->addScreaning($screaning1);

        $cinema->addMovieTheater($movieTheater1);
        $manager->persist($cinema);
        $manager->flush();


    }
}
