<?php

namespace App\Controller\Admin;

use App\Entity\Cinema;
use App\Entity\MovieTheater;
use App\Entity\Screening;
use App\Entity\Seat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MovieTheaterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MovieTheater::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            AssociationField::new('seats')
                ->setCustomOption('multiple', true)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'required' => true,
                    'class' => Seat::class,
                    'choice_label' => function (Seat $seat) {
                        return sprintf('%s | seat - %s - %s', $seat->getMovieTheater()->getName(), $seat->getSeatRow(), $seat->getSeatNumber());
                    },
                ]),
            AssociationField::new('cinema', 'Cinema')
                ->setCustomOption('multiple', false)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'required' => true,
                    'class' => Cinema::class,
                    'choice_label' => function (Cinema $cinema) {
                        return sprintf('%s - %s, %s', $cinema->getCity(), $cinema->getName(), $cinema->getAddress());
                    },
                ]),
            AssociationField::new('screenings')
                ->setCustomOption('multiple', false)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'required' => true,
                    'class' => Screening::class,
                    'choice_label' => function (Screening $screening) {
                        return sprintf('%s - %s - %s', $screening->getMovieTheater()->getName(), $screening->getMovie()->getTitle(), $screening->getStartTime()->format('H:i'));
                    },
                ]),

        ];
    }

}
