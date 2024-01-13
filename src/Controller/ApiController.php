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
        // hardcore totalny
        $cinemaId = $request->query->get('cinema');
        $movieId = $request->query->get('movie');

        $screenings = $screeningRepository->findScreeningsByMovieAndCinema($movieId, $cinemaId);

        $data = [];
        // jak juz mam screening po movie i po cinema to getuje co potrzeba i zwracam
        // mysle nad dodaniem jakiego if ze jak dane sa puste to zwroc cos tam, ale moze lepiej to w js zrobic nwm
        foreach ($screenings as $screening) {
            $data[] = [
                'movieTitle' => $screening->getMovie()->getTitle(),
                'screeningStartTime' => $screening->getStartTime()->format('Y-m-d H:i:s'),
                'movieTheaterName' => $screening->getMovieTheater()->getName()
            ];
        }

        return new JsonResponse($data);
    }
}
