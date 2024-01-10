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

        $cinema->addMovieTheater($movieTheater1);
        $cinema->addMovieTheater($movieTheater2);
        $manager->persist($cinema);
        $manager->flush();

    }
}
