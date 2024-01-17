<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user', priority: 5)]
    public function index(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return new Response("no chyba nie XD");
        }

        $userName = $user->getName();

        return $this->render('user/index.html.twig', [
            'userName' => $userName
        ]);
    }
}
