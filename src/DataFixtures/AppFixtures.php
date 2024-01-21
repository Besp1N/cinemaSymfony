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
        // tworzenie 10 unikalnych userow z czego 2 z nich to admini

        $user1 = new User();
        $user1->setName('Kacper');
        $user1->setProfilePicture('brak');
        $user1->setBio('no bio here');
        $user1->setLastname('Karabinowski');
        $user1->setEmail('kacper@user.pl');
        $user1->setCreatedAt(new \DateTimeImmutable());
        $user1->setRoles(['ROLE_USER']);
        $user1->setPhoneNumber('+48 123 456 789');
        $user1->setPassword($this->userPasswordHasher->hashPassword($user1, '12345678'));

        $user1Admin = new User();
        $user1Admin->setName('Kacper');
        $user1Admin->setProfilePicture('brak');
        $user1Admin->setBio('no bio here');
        $user1Admin->setLastname('Karabinowski');
        $user1Admin->setEmail('kacper@admin.pl');
        $user1Admin->setCreatedAt(new \DateTimeImmutable());
        $user1Admin->setRoles(['ROLE_ADMIN']);
        $user1Admin->setPhoneNumber('+48 123 456 789');
        $user1Admin->setPassword($this->userPasswordHasher->hashPassword($user1Admin, '12345678'));

        $user2 = new User();
        $user2->setName('Klaudiusz');
        $user2->setProfilePicture('brak');
        $user2->setBio('no bio here');
        $user2->setLastname('Petryk');
        $user2->setEmail('klaudiusz@user.pl');
        $user2->setCreatedAt(new \DateTimeImmutable());
        $user2->setRoles(['ROLE_USER']);
        $user2->setPhoneNumber('+48 987 654 321');
        $user2->setPassword($this->userPasswordHasher->hashPassword($user2, '12345678'));

        $user2Admin = new User();
        $user2Admin->setName('Klaudiusz');
        $user2Admin->setProfilePicture('brak');
        $user2Admin->setBio('no bio here');
        $user2Admin->setLastname('Petryk');
        $user2Admin->setEmail('klaudiusz@admin.pl');
        $user2Admin->setCreatedAt(new \DateTimeImmutable());
        $user2Admin->setRoles(['ROLE_ADMIN']);
        $user2Admin->setPhoneNumber('+48 987 654 321');
        $user2Admin->setPassword($this->userPasswordHasher->hashPassword($user2Admin, '12345678'));

        $user3 = new User();
        $user3->setName('Anna');
        $user3->setProfilePicture('brak');
        $user3->setBio('no bio here');
        $user3->setLastname('Nowak');
        $user3->setEmail('anna.nowak@user.pl');
        $user3->setCreatedAt(new \DateTimeImmutable());
        $user3->setRoles(['ROLE_USER']);
        $user3->setPhoneNumber('+48 601 234 567');
        $user3->setPassword($this->userPasswordHasher->hashPassword($user3, '12345678'));

        $user4 = new User();
        $user4->setName('Anastazja');
        $user4->setProfilePicture('brak');
        $user4->setBio('no bio here');
        $user4->setLastname('Kowalska');
        $user4->setEmail('anastazja.kowalska@user.pl');
        $user4->setCreatedAt(new \DateTimeImmutable());
        $user4->setRoles(['ROLE_USER']);
        $user4->setPhoneNumber('+48 602 345 678');
        $user4->setPassword($this->userPasswordHasher->hashPassword($user4, '12345678'));

        $user5 = new User();
        $user5->setName('Sylwia');
        $user5->setProfilePicture('brak');
        $user5->setBio('no bio here');
        $user5->setLastname('Nowak');
        $user5->setEmail('sylwia.nowak@user.pl');
        $user5->setCreatedAt(new \DateTimeImmutable());
        $user5->setRoles(['ROLE_USER']);
        $user5->setPhoneNumber('+48 603 456 789');
        $user5->setPassword($this->userPasswordHasher->hashPassword($user5, '12345678'));

        $user6 = new User();
        $user6->setName('Adam');
        $user6->setProfilePicture('brak');
        $user6->setBio('no bio here');
        $user6->setLastname('Kowalski');
        $user6->setEmail('adam.kowalski@user.pl');
        $user6->setCreatedAt(new \DateTimeImmutable());
        $user6->setRoles(['ROLE_USER']);
        $user6->setPhoneNumber('+48 604 567 890');
        $user6->setPassword($this->userPasswordHasher->hashPassword($user6, '12345678'));

        $user7 = new User();
        $user7->setName('Kordian');
        $user7->setProfilePicture('brak');
        $user7->setBio('no bio here');
        $user7->setLastname('Nowak');
        $user7->setEmail('kordian.nowak@user.pl');
        $user7->setCreatedAt(new \DateTimeImmutable());
        $user7->setRoles(['ROLE_USER']);
        $user7->setPhoneNumber('+48 605 678 901');
        $user7->setPassword($this->userPasswordHasher->hashPassword($user7, '12345678'));

        $user8 = new User();
        $user8->setName('Karolina');
        $user8->setProfilePicture('brak');
        $user8->setBio('no bio here');
        $user8->setLastname('Nowak');
        $user8->setEmail('karolina.nowak@user.pl');
        $user8->setCreatedAt(new \DateTimeImmutable());
        $user8->setRoles(['ROLE_USER']);
        $user8->setPhoneNumber('+48 606 789 012');
        $user8->setPassword($this->userPasswordHasher->hashPassword($user8, '12345678'));


        // tworzenie 8 filmow po 2 gatunki
        // Gatunek Adventure - Film 1
        // kazdy film trwa 2 godziny
        $duration = new DateTimeImmutable();
        $duration->setTime(2,0);

        $movie1 = new Movie();
        $movie1->setTitle('Indiana Jones and Raiders of the lost Ark');
        $movie1->setDescription(
            'The year is 1936 and the intrepid archaeologist Indiana Jones sets out in search
             of the fabled Lost Ark of the Covenant, racing a bitter rival and his Nazi cohorts to the prize.');
        $movie1->setDirector('Steven Spielberg');
        $movie1->setGenre('Adventure');
        $movie1->setDuration($duration);
        $movie1->setRating(5.0);
        $movie1->setReleaseYear(new DateTime());
        $movie1->setImage("images/poster1.jpg");

        // Gatunek Adventure - Film 2
        $movie2 = new Movie();
        $movie2->setTitle('Jurassic Park');
        $movie2->setDescription(
            'The story is about Jurassic Park, a nature reserve on a remote
         South American island owned by billionaire businessman John Hammond (Richard Attenborough).
         Hammond and his team of dedicated scientists have populated the park with genetically engineered dinosaurs.');
        $movie2->setDirector('Steven Spielberg');
        $movie2->setGenre('Adventure');
        $movie1->setDuration($duration);
        $movie2->setRating(4.0);
        $movie2->setReleaseYear(new DateTime());
        $movie2->setImage("images/poster2.jpg");

        // Gatunek Crime - Film 3
        $movie3 = new Movie();
        $movie3->setTitle('The Godfather');
        $movie3->setDescription(
            'The Godfather is set in the 1940s and takes place entirely within
         the world of the Corleones, a fictional New York Mafia family. It opens inside the dark office
         of the family patriarch, Don Vito Corleone (also known as the Godfather and played by Brando),
         on the wedding day of his daughter, Connie (Talia Shire).');
        $movie3->setDirector('Francis Ford Coppola');
        $movie3->setGenre('Crime');
        $movie3->setDuration($duration);
        $movie3->setRating(5.0);
        $movie3->setReleaseYear(new DateTime());
        $movie3->setImage("images/poster3.jpg");

        // Gatunek 2 - Film 4
        $movie4 = new Movie();
        $movie4->setTitle('Pulp Fiction');
        $movie4->setDescription(
            'The lives of two mob hitmen, a boxer, a gangster and his wife,
         and a pair of diner bandits intertwine in four tales of violence and redemption.');
        $movie4->setDirector('Quentin Tarantino');
        $movie4->setGenre('Crime');
        $movie4->setDuration($duration);
        $movie4->setRating(3.0);
        $movie4->setReleaseYear(new DateTime());
        $movie4->setImage("images/poster4.jpg");

        // Gatunek Science Fiction - Film 5
        $movie5 = new Movie();
        $movie5->setTitle('Inception');
        $movie5->setDescription(
            'Summaries. A thief who steals corporate secrets through the use of dream-sharing
         technology is given the inverse task of planting an idea into the mind of a C.E.O.,
         but his tragic past may doom the project and his team to disaster.');
        $movie5->setDirector('Christopher Nolan');
        $movie5->setGenre('Science Fiction');
        $movie5->setDuration($duration);
        $movie5->setRating(4.5);
        $movie5->setReleaseYear(new DateTime());
        $movie5->setImage("images/poster5.jpg");

        // Gatunek Science Fiction - Film 6
        $movie6 = new Movie();
        $movie6->setTitle('Blade Runner');
        $movie6->setDescription(
            'Plot. The movie takes place in humid rainy climate changed Los Angeles in November 2019
         when artificial human adults called "replicants" come to Earth.');
        $movie6->setDirector('Ridley Scott');
        $movie6->setGenre('Science Fiction');
        $movie6->setDuration($duration);
        $movie6->setRating(4.0);
        $movie6->setReleaseYear(new DateTime());
        $movie6->setImage("images/poster6.jpg");

        // Gatunek Drama - Film 7
        $movie7 = new Movie();
        $movie7->setTitle('Forrest Gump');
        $movie7->setDescription(
            'Forrest Gump, American film, released in 1994, that chronicled 30
         years (from the 1950s through the early 1980s) of the life of a intellectually disabled man
         (played by Tom Hanks) in an unlikely fable that earned critical praise, large audiences,
         and six Academy Awards, including best picture.');
        $movie7->setDirector('Robert Zemeckis');
        $movie7->setGenre('Drama');
        $movie7->setDuration($duration);
        $movie7->setRating(2.0);
        $movie7->setReleaseYear(new DateTime());
        $movie7->setImage("images/poster7.jpg");

        // Gatunek Drama - Film 8
        $movie8 = new Movie();
        $movie8->setTitle('Call me by your name');
        $movie8->setDescription(
            'Set in 1983 in northern Italy, Call Me by Your Name chronicles
         the romantic relationship between a 17-year-old, Elio Perlman (Timothée Chalamet),
         and Oliver (Armie Hammer), a 24-year-old graduate-student assistant to Elio father Samuel
         (Michael Stuhlbarg), an archaeology professor.');
        $movie8->setDirector('Frank Darabont');
        $movie8->setGenre('Drama');
        $movie8->setDuration($duration);
        $movie8->setRating(5.0);
        $movie8->setReleaseYear(new DateTime());
        $movie8->setImage("images/poster8.jpg");



        // Tworzenie 3 kin
        $cinema1 = new Cinema();
        $cinema1->setName("Multikino");
        $cinema1->setCity("Warszawa");
        $cinema1->setAddress("Zielona 1");
        $cinema1->setCoords('53.123,18.000');

        $cinema2 = new Cinema();
        $cinema2->setName("Kino Max");
        $cinema2->setCity("Gdansk");
        $cinema2->setAddress("Niebieska 2");
        $cinema2->setCoords('53.123,18.000');

        $cinema3 = new Cinema();
        $cinema3->setName("Cinema City");
        $cinema3->setCity("Krakow");
        $cinema3->setAddress("Czerwona 3");
        $cinema3->setCoords('53.123,18.000');


        // Tworzenie 6 sal kinowych po 2 na kazde kino
        $movieTheater1 = new MovieTheater();
        $movieTheater1->setName("Sala 1");

        $movieTheater2 = new MovieTheater();
        $movieTheater2->setName("Sala 2");

        $movieTheater3 = new MovieTheater();
        $movieTheater3->setName("Sala 1");

        $movieTheater4 = new MovieTheater();
        $movieTheater4->setName("Sala 2");

        $movieTheater5 = new MovieTheater();
        $movieTheater5->setName("Sala 1");

        $movieTheater6 = new MovieTheater();
        $movieTheater6->setName("Sala 2");

        $cinema1->addMovieTheater($movieTheater1);
        $cinema1->addMovieTheater($movieTheater2);
        $cinema2->addMovieTheater($movieTheater3);
        $cinema2->addMovieTheater($movieTheater4);
        $cinema3->addMovieTheater($movieTheater5);
        $cinema3->addMovieTheater($movieTheater6);


        // Tworzenie 30 siedzen na dupe w sali kinowej
        $seatTypes = ["Handicapped", "Vip", "Regular"];
        $seatRows = ["A", "B", "C"];
        $seatNumbers = ["1", "2"];
        $totalSeats = 30;
        $movieTheaters = [
            $movieTheater1,
            $movieTheater2,
            $movieTheater3,
            $movieTheater4,
            $movieTheater5,
            $movieTheater6
        ];

        $seatCounter = 0;
        foreach ($movieTheaters as $movieTheater) {
            foreach ($seatRows as $row) {
                foreach ($seatNumbers as $number) {
                    $seat = new Seat();
                    $seat->setSeatRow($row);
                    $seat->setSeatNumber($number);
                    $seat->setSeatType($seatTypes[array_rand($seatTypes)]);
                    $movieTheater->addSeat($seat);
                    $seatCounter++;

                    if ($seatCounter == $totalSeats) {
                        break 3;
                    }
                }
            }
        }


        // Dodawanie seansow
        $screening1 = new Screening();
        $screening1->setMovie($movie1);
        $screening1->setStartTime(new DateTimeImmutable('2024-02-01 12:00'));

        $screening2 = new Screening();
        $screening2->setMovie($movie2);
        $screening2->setStartTime(new DateTimeImmutable('2024-02-02 12:00'));

        $screening3 = new Screening();
        $screening3->setMovie($movie3);
        $screening3->setStartTime(new DateTimeImmutable('2024-02-03 12:00'));

        $screening4 = new Screening();
        $screening4->setMovie($movie4);
        $screening4->setStartTime(new DateTimeImmutable('2024-02-04 12:00'));

        $screening5 = new Screening();
        $screening5->setMovie($movie5);
        $screening5->setStartTime(new DateTimeImmutable('2024-02-05 12:00'));

        $screening6 = new Screening();
        $screening6->setMovie($movie6);
        $screening6->setStartTime(new DateTimeImmutable('2024-02-06 12:00'));

        $movieTheater1->addScreening($screening1);
        $movieTheater2->addScreening($screening2);
        $movieTheater3->addScreening($screening3);
        $movieTheater4->addScreening($screening4);
        $movieTheater5->addScreening($screening5);
        $movieTheater6->addScreening($screening6);


        // Blagam zeby to dzialalo <3
        $manager->persist($user1);
        $manager->persist($user1Admin);
        $manager->persist($user2);
        $manager->persist($user2Admin);
        $manager->persist($user3);
        $manager->persist($user4);
        $manager->persist($user5);
        $manager->persist($user7);
        $manager->persist($user8);

        $manager->persist($cinema1);
        $manager->persist($cinema2);
        $manager->persist($cinema3);
        $manager->flush();


    }
}
