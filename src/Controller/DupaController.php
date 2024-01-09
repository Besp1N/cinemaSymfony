<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
=======
use Symfony\Flex\Response;
>>>>>>> assets

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
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('base.html.twig');
>>>>>>> assets
    }
}
