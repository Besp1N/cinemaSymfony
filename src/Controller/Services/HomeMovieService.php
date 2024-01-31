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

    /*
     * processMovie function return an array with all required data to render view
     */
    public function processMovie(Movie $movie, $user): array
    {
        $rates = $this->ratesRepository->findBy(['movie' => $movie]);
        $allRates = 0;
        $ratesCount = count($rates);
        $isAllowed = true;

        /*
         * isAllowed is a flag to check if a user can rate a movie
         * if user one rated a movie, it can't be rate by that user
         */
        foreach ($rates as $rate) {
            if ($rate->getUser() === $user) {
                $isAllowed = false;
                break;
            }
        }

        /*
         * calculating avg rating, if there's no any rated then rate is 0
         */
        if ($ratesCount != 0) {
            foreach ($rates as $rate) {
                $allRates += ($rate->getRate());
            }
            $avgRate = round($allRates / $ratesCount);
        } else {
            $avgRate = 0;
        }

        // setting movie rating
        $movie->setRating($avgRate);

        return [
            'movie' => $movie,
            'cinemas' => $this->cinemaRepository->findAll(),
            'rating' => (int) $avgRate,
            'isAllowed' => $isAllowed,
        ];
    }
}