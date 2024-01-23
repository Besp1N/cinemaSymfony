<?php

// src/Form/ReservationType.php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Screening;
use App\Entity\Seat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $seatsWithStatus = $options['seatsWithStatus'];
//        dd($seatsWithStatus);
        $builder
            ->add('seat', EntityType::class, [
                'class' => Seat::class,
                'choices' => $seatsWithStatus,


            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'seatsWithStatus' => null
        ]);
    }
}
