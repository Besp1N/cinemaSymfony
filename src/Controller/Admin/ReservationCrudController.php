<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use App\Entity\Screening;
use App\Entity\Seat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpParser\Node\Expr\AssignOp;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user'),
            AssociationField::new('seat')
                ->setCustomOption('multiple', true)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'required' => true,
                    'class' => Seat::class,
                    'choice_label' => function (Seat $seat) {
                        $movieTheater = $seat->getMovieTheater();
                        $cinema = $movieTheater?->getCinema();

                        $movieTheaterName = $movieTheater ? $movieTheater->getName() : 'Unknown Movie Theater';

                        return sprintf('%s | %s | %s | %s | %s - %s', $cinema->getCity(), $cinema->getName(), $cinema->getAddress(), $movieTheaterName, $seat->getSeatRow(), $seat->getSeatNumber());
                    },
                ]),
            AssociationField::new('screening')
                ->setCustomOption('multiple', false)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'required' => true,
                    'class' => Screening::class,
                    'choice_label' => function (Screening $screening) {
                        $movieTheater = $screening->getMovieTheater();
                        $movie = $screening->getMovie();
                        $cinema = $movieTheater?->getCinema();

                        $movieTheaterName = $movieTheater ? $movieTheater->getName() : 'Unknown Movie Theater';
                        $movieTitle = $movie ? $movie->getTitle() : 'Unknown Movie';
                        $cinemaName = $cinema ? sprintf('%s - %s | %s', $cinema->getCity(), $cinema->getName(), $cinema->getAddress()) : 'Unknown Cinema';

                        return sprintf('%s | %s | %s | %s', $cinemaName, $movieTheaterName, $movieTitle, $screening->getStartTime()->format('H:i'));
                    },
                ]),

        ];
    }

}
