<?php

namespace App\Controller\Login;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', priority: 3)]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('login/index.html.twig', [
            'error' => $error
        ]);
    }

    #[Route('/logout', name: 'app_logout', priority: 3)]
    public function logout()
    {

    }
}

