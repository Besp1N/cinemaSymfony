<?php

namespace App\Controller;

use App\Entity\Screening;
use App\Repository\CinemaRepository;
use App\Repository\MovieRepository;
use App\Repository\ScreeningRepository;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Validator\Constraints\Json;

class ApiController extends AbstractController
{
    #[Route('/api/screenings', name: 'app_api')]
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

    #[Route('/api/movies', name: 'api_movies')]
    public function Movies(Request $request ,MovieRepository $movieRepository): JsonResponse
    {
        $movieTitle = $request->query->get('title');

        // to ponizej to na testa tylko ( nawet po wars zwraca )
        // $movieTitle = "wars";
        $movies = $movieRepository->findMovieByTitle($movieTitle);

        $data = [];
        foreach ($movies as $movie) {
            $data[] = [
                "id" => $movie->getId(),
                "title" => $movie->getTitle()
            ];
        }
        return new JsonResponse($data);
    }

    #[Route('/api/cinemas', name: 'api_cinemas')]
    public function Cinemas(CinemaRepository $cinemaRepository, Request $request): JsonResponse
    {

        $id = $request->get('id');
        if (!is_null($id)) {
            $cinema =  $cinemaRepository->find($id);
            if (!$cinema) {
                return new JsonResponse(null, 404);
            }
            $data = [ 'id' => $cinema->getId(),
                'name' => $cinema->getName(),
                'address' => $cinema->getAddress(),
                'city' => $cinema->getCity(),
                'coords' => $cinema->getCoords()
            ];
            return new JsonResponse($data);
        }

        $allCinemas = $cinemaRepository->findAll();

        $data = [];
        foreach ($allCinemas as $cinema) {
            $data[] = [
              'id' => $cinema->getId(),
              'name' => $cinema->getName(),
                'address' => $cinema->getAddress(),
                'city' => $cinema->getCity(),
              'coords' => $cinema->getCoords()
            ];
        }

        return new JsonResponse($data);
    }


    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request, UserRepository $userRepository, JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user = $userRepository->findOneBy(['username' => $username]);

        if (!$user) {
            throw new BadCredentialsException('Invalid credentials');
        }

        // Symfony automatycznie sprawdzi hasło w procesie uwierzytelniania.

        $token = $jwtManager->create($user);

        return new JsonResponse(['token' => $token]);
    }
}
