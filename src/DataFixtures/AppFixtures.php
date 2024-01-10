<?php

namespace App\DataFixtures;

use App\Entity\Cinema;
use App\Entity\MovieTheaters;
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

        $cinema->addMovieTheater($movieTheater1);
        $cinema->addMovieTheater($movieTheater2);
        $manager->persist($cinema);
        $manager->flush();
    }
}
