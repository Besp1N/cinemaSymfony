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

        // testowe zwracanie gatunkow - sa w home.html.twig na samym dole
        // nspisalem query ktore zwraca unikalne gatunki ( bez powtorzen )
        $genres = $movieRepository->findUniqueGenres();
        $flatGenres = array_column($genres, 'genre');

        return $this->render('home/home.html.twig', [
            "movies" => $movies,
            "genres" => $flatGenres
        ]);
    }

    #[Route('/{movie}', name: 'app_home_movie')]
    public function showMovie(Movie $movie, ScreeningRepository $screeningRepository, CinemaRepository $cinemaRepository, MovieRepository $movieRepository): Response
    {
        return $this->render('home/movie.html.twig', [
            "movie" => $movie,
            "screenings" => $screeningRepository->findBy(
                ["movie" => $movie],
                ["start_time" => "ASC"]
            ),
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
}
