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
    /*
     * index function is home view of app
     * it returns movies to view but with limit to not overload render func
     */
    #[Route('/', name: 'app_home')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findBy([], ['id' => 'ASC'], 10);
        return $this->render('home/home.html.twig', [
            "movies" => $movies,
        ]);
    }

    /*
     * each movie has own path to render only that movie.
     * showMovie function uses HomeMovieService to make it working better
     */
    #[Route('/{movie}', name: 'app_home_movie')]
    public function showMovie(
        Movie $movie,
        HomeMovieService $homeMovieService
    ): Response {

        $user = $this->getUser();
        $result = $homeMovieService->processMovie($movie, $user);

        return $this->render('home/movie.html.twig', $result);
    }

    /*
     * showResults function is for searching movies by genre,
     * it's finding movies by genre and returns them into view
     */
    #[Route('/genre/{genre}', name: 'app_home_show')]
    public function showResults(String $genre, MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findBy(["genre" => $genre]);
        return $this->render('home/results.html.twig', [
            "movies" => $movies,
            "headerText" => "Results for ".$genre,
        ]);
    }

    /*
     * showSearchResults function is for searching movies by phrase,
     * f.e typing 'star' into input this function will return all
     * movies which contains star phrase.
     * This function also uses JavaScript logic to render movies
     * before press enter
     */
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
