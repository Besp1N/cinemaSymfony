<?php

namespace App\Controller;

use App\Entity\Screening;
use App\Repository\CinemaRepository;
use App\Repository\MovieRepository;
use App\Repository\ScreeningRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api_screenings', name: 'app_api')]
    public function index(Request $request, CinemaRepository $cinemaRepository): JsonResponse
    {
        $cinemaId = $request->query->get('cinema');
        $cinema = $cinemaRepository->find($cinemaId);

        // jak nie znajdzie kina ( ktos wybierze te kreski ) to zwraca not found
        if (!$cinema) {
            return new JsonResponse(['error' => 'Cinema not found.'], Response::HTTP_NOT_FOUND);
        }

        $movies = [];

        foreach ($cinema->getMovieTheaters() as $movieTheater) {
            foreach ($movieTheater->getScreenings() as $screening) {
                $movies[] = [
                    'id' => $screening->getMovie()->getId(),
                    'title' => $screening->getMovie()->getTitle(),
                ];
            }
        }

        $jsonMovies = json_encode($movies);
        return new JsonResponse($jsonMovies);
    }
}
