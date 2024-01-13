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
    public function index(Request $request, ScreeningRepository $screeningRepository): JsonResponse
    {
        $cinemaId = $request->query->get('cinema');
        $movieId = $request->query->get('movie');

        $screenings = $screeningRepository->findScreeningsByMovieAndCinema($movieId, $cinemaId);

        $data = [];
        foreach ($screenings as $screening) {
            $data[] = [
                'movie' => $screening->getMovie()->getTitle(),
                'startTime' => $screening->getStartTime()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse($data);
    }
}
