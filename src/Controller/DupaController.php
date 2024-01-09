<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
<<<<<<< HEAD
=======
use Symfony\Component\HttpFoundation\Response;
>>>>>>> database
use Symfony\Component\Routing\Annotation\Route;

class DupaController extends AbstractController
{
    #[Route('/dupa', name: 'app_dupa')]
<<<<<<< HEAD
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DupaController.php',
            'kacper' => 'to bambik'
        ]);
=======
    public function index(): Response
    {
       return new Response("dupa");
>>>>>>> database
    }
}
