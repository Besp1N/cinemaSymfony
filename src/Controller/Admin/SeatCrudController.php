<?php

namespace App\Controller\Admin;

use App\Entity\MovieTheater;
use App\Entity\Seat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SeatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Seat::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('movie_theater')
                ->setCustomOption('multiple', false)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'required' => true,
                    'class' => MovieTheater::class,
                    'choice_label' => function (MovieTheater $movieTheater) {
                        return sprintf('%s - %s', $movieTheater->getCinema()->getName(), $movieTheater->getName());
                    },
                ]),
            AssociationField::new('reservations'),
            TextField::new('seat_row'),
            TextField::new('seat_number'),
            TextField::new('seat_type'),
        ];
    }

}
