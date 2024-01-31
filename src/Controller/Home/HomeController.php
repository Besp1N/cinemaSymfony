<?php

namespace App\Controller\Home;


use App\Controller\Services\HomeMovieService;
use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findBy([], ['id' => 'ASC'], 10);
        return $this->render('home/home.html.twig', [
            "movies" => $movies,
        ]);
    }

    #[Route('/{movie}', name: 'app_home_movie')]
    public function showMovie(
        Movie $movie,
        HomeMovieService $homeMovieService): Response {

            $user = $this->getUser();
            $result = $homeMovieService->processMovie($movie, $user);

            return $this->render('home/movie.html.twig', $result);
    }

    #[Route('/genre/{genre}', name: 'app_home_show')]
    public function showResults(String $genre, MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findBy(["genre" => $genre]);
        return $this->render('home/results.html.twig', [
            "movies" => $movies,
            "headerText" => "Results for ".$genre,
        ]);
    }


    #[Route('/search', name: 'app_home_search', methods: ['GET'], priority: 1)]
    public function showSearchResults(Request $request, MovieRepository $movieRepository): Response
    {
        $query = $request->get('q');
        if (!$query) {
            return $this->redirectToRoute('app_home');
        }

        $movies = $movieRepository->findMovieByTitle($query, 10, 0);
        return $this->render('home/results.html.twig', [
           'movies' => $movies,
           'query' => $query
        ]);

    }

}
