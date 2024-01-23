<?php

namespace App\Controller;

use App\Entity\Screening;
use App\Repository\CinemaRepository;
use App\Repository\MovieRepository;
use App\Repository\ScreeningRepository;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
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
        $dateString = $request->query->get('datetime');
        $cinemaId = $request->query->get('cinema');
        $movieId = $request->query->get('movie');

        if ($dateString) {
            $dateArray = explode('-', $dateString);
            $year = $dateArray[0];
            $month = $dateArray[1];
            $day = $dateArray[2];
            $datetime =  new DateTime("$year-$month-$day");



            $screenings = $screeningRepository->findScreeningsByMovieCinemaAndDate($movieId, $cinemaId, $datetime);

            $data = [];


            foreach ($screenings as $screening) {
                $data[] = [
                    'screeningId' => $screening->getId(),
                    'movieTitle' => $screening->getMovie()->getTitle(),
                    'screeningStartTime' => $screening->getStartTime()->format('Y-m-d H:i:s'),
                    'movieTheaterName' => $screening->getMovieTheater()->getName()
                ];
            }
            return new JsonResponse($data);
        }

        $screenings = $screeningRepository->findScreeningsByMovieAndCinema($movieId, $cinemaId);

        $data = [];
        // jak juz mam screening po movie i po cinema to getuje co potrzeba i zwracam
        // mysle nad dodaniem jakiego if ze jak dane sa puste to zwroc cos tam, ale moze lepiej to w js zrobic nwm

        foreach ($screenings as $screening) {
            $data[] = [
                'screeningId' => $screening->getId(),
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
        $limit = $request->query->get('limit');

        if (!$limit or $limit > 10) {
            $limit = 10;
        }
        if ($movieTitle) {
            $movies = $movieRepository->findMovieByTitle($movieTitle, $limit);
        }
        else {
            $movies = $movieRepository->findBy([], limit: $limit);
        }

        $data = [];
        foreach ($movies as $movie) {
            $data[] = [
                "id" => $movie->getId(),
                "title" => $movie->getTitle(),
                "image" => $movie->getImage()
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
