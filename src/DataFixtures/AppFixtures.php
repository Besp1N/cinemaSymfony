<?php

namespace App\DataFixtures;

use App\Entity\Cinema;
use App\Entity\MovieTheaters;
use App\Entity\Seat;
use App\Entity\Test;
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

        // adding movie theaters to cinema and push to database
        $cinema->addMovieTheater($movieTheater1);
        $cinema->addMovieTheater($movieTheater2);
        $manager->persist($cinema);
        $manager->flush();

    }
}
