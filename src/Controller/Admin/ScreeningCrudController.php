<?php

namespace App\Controller\Admin;

use App\Entity\MovieTheater;
use App\Entity\Screening;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ScreeningCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Screening::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('movie'),
            DateTimeField::new('start_time'),
            AssociationField::new('movie_theater', 'Movie theater')
                ->setCustomOption('multiple', false)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'required' => false,
                    'class' => MovieTheater::class,
                    'choice_label' => function (MovieTheater $movieTheater) {
                        return sprintf('%s | %s | %s | %s', $movieTheater->getCinema()->getName(), $movieTheater->getCinema()->getCity(), $movieTheater->getCinema()->getAddress() ,$movieTheater->getName());
                    }
                ])


        ];
    }

}
