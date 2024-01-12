<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api_screenings', name: 'app_api')]
    public function index(Request $request, MovieRepository $movieRepository): JsonResponse
    {
        $movie = $movieRepository->find(['id' => $request->get('movie')]);


        return new JsonResponse(json_encode(['dupa' => $movie->getTitle()]));
    }
}
