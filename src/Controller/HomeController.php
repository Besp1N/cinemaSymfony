<?php

namespace App\Controller;


use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\CinemaRepository;
use App\Repository\MovieRepository;
use App\Repository\ScreeningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('home/home.html.twig', [
            "movies" => $movies,
        ]);
    }

    #[Route('/{movie}', name: 'app_home_movie')]
    public function showMovie(Movie $movie, ScreeningRepository $screeningRepository, CinemaRepository $cinemaRepository, MovieRepository $movieRepository): Response
    {
        return $this->render('home/movie.html.twig', [
            "movie" => $movie,
            "cinemas" => $cinemaRepository->findAll(),
        ]);
    }

    #[Route('/add_movie', name: 'app_home_movie_add', priority: 2)]
    public function addMovie(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MovieType::class, new Movie());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();
            $entityManager->persist($movie);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/add.html.twig', [
            "form" => $form
        ]);
    }
    #[Route('/genre/{genre}', name: 'app_home_show')]
    public function showResults(String $genre, MovieRepository $movieRepository): Response {
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

        $movies = $movieRepository->findMovieByTitle($query);
        if (empty($movies)) {
            $headerText = 'No results for '. $query;
        }else {
            $headerText = 'Results for '. $query;
        }
        return $this->render('home/results.html.twig', [
           'movies' => $movies,
            'headerText' => $headerText
        ]);

    }

}
