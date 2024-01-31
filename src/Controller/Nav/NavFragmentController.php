<?php

namespace App\Controller\Nav;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NavFragmentController extends AbstractController
{
    public function index(MovieRepository $movieRepository): Response
    {
        $genres = $movieRepository->findUniqueGenres();
        $flatGenres = array_column($genres, 'genre');

        return $this->render('components/_navbar.html.twig', [
            "genres" => $flatGenres
        ]);
    }
}
