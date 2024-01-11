<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();
        return $this->render('home/home.html.twig', [
            "movies" => $movies
        ]);
    }

    #[Route('/{movie}', name: 'app_home_movie')]
    public function showMovie(Movie $movie): Response
    {
       return $this->render('home/movie.html.twig', [
           "movie" => $movie,
       ]);
    }
}
