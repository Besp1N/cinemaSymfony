<?php

namespace App\DataFixtures;

use App\Entity\Cinema;
use App\Entity\Movie;
use App\Entity\MovieTheaters;
use App\Entity\Screaning;
use App\Entity\Seat;
use App\Entity\Test;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //creating a cinema
        $cinema = new Cinema();
        $cinema->setName("multikino");
        $cinema->setCity("slupsk");
        $cinema->setAddress("zielona4");

        // creating 2 movie theaters
        $movieTheater1 = new MovieTheaters();
        $movieTheater1->setName("sala1");
        $movieTheater2 = new MovieTheaters();
        $movieTheater2->setName("sala2");

        // creating 2 seats
        $seat1 = new Seat();
        $seat1->setSeatType("vip");
        $seat1->setSeatRow("A");
        $seat1->setSeatNumber("7");
        $seat2 = new Seat();
        $seat2->setSeatType("vip");
        $seat2->setSeatRow("B");
        $seat2->setSeatNumber("8");

        // adding 2 seats to movie theaters
        $movieTheater1->addSeat($seat1);
        $movieTheater2->addSeat($seat2);

        // setting movie ( image can be null )
        $movie1 = new Movie();
        $movie1->setTitle("Indiana Jones");
        $movie1->setDescription("hit nad hity");
        $movie1->setDirector("Steven Spielberg");
        $movie1->setGenre("advanture");
        $movie1->setDuration(new DateTime());
        $movie1->setRating(5.0);
        $movie1->setRelaseYear(1980);

        //setting screaning and adding a movie
        $screaning1 = new Screaning();
        $screaning1->setMovie($movie1);
        $screaning1->setStartTime(new DateTime());

        // adding screaning to each movie theaters
        $movieTheater1->addScreaning($screaning1);

        // adding movie theaters to cinema and push to database
        $cinema->addMovieTheater($movieTheater1);
        $cinema->addMovieTheater($movieTheater2);
        $manager->persist($cinema);
        $manager->flush();

    }
}
