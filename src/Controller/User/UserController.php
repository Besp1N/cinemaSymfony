<?php

namespace App\Controller\User;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{user}', name: 'app_user', priority: 5)]
    public function index(User $user): Response {
        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }
}
