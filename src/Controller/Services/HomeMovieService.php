<?php

namespace App\Controller\Services;

use App\Entity\Movie;
use App\Repository\CinemaRepository;
use App\Repository\RatesRepository;

class HomeMovieService
{
    private RatesRepository $ratesRepository;
    private CinemaRepository $cinemaRepository;

    public function __construct(RatesRepository $ratesRepository, CinemaRepository $cinemaRepository)
    {
        $this->ratesRepository = $ratesRepository;
        $this->cinemaRepository = $cinemaRepository;
    }

    public function processMovie(Movie $movie, $user): array
    {
        $rates = $this->ratesRepository->findBy(['movie' => $movie]);
        $allRates = 0;
        $ratesCount = count($rates);
        $isAllowed = true;

        foreach ($rates as $rate) {
            if ($rate->getUser() === $user) {
                $isAllowed = false;
                break;
            }
        }

        if ($ratesCount != 0) {
            foreach ($rates as $rate) {
                $allRates += ($rate->getRate());
            }
            $avgRate = round($allRates / $ratesCount);
        } else {
            $avgRate = 0;
        }

        $movie->setRating($avgRate);

        return [
            'movie' => $movie,
            'cinemas' => $this->cinemaRepository->findAll(),
            'rating' => (int) $avgRate,
            'isAllowed' => $isAllowed,
        ];
    }
}