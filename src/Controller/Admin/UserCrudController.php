<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('lastname'),
            TextField::new('password'),
            TextField::new('email'),
            DateTimeField::new('created_at', 'created at')
                ->setFormTypeOptions([
                    'html5' => true,
                    'data' => new \DateTimeImmutable(),
                ]),
            TextField::new('role'),
            TextField::new('profile_picture'),
            TextField::new('phone_number'),
        ];
    }

}
