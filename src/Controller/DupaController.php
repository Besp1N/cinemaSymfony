<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;

class DupaController extends AbstractController
{
    #[Route('/dupa', name: 'app_dupa')]
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('base.html.twig');
    }
}
