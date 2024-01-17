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

        // symfony ma jakis problem z tym ale to dziala wiec gitara
        $userName = $user->getName();
        $userLastname = $user->getLastname();
        $userCreatedAt = $user->getCreatedAt()->format('Y-m-d');
        $userEmail = $user->getEmail();
        $userProfilePicture = $user->getProfilePicture();

        return $this->render('user/index.html.twig', [
            'userName' => $userName,
            'userLastname' => $userLastname,
            'userCreatedAt' => $userCreatedAt,
            'userEmail' => $userEmail,
            'userProfilePicture' => $userProfilePicture
        ]);
    }
}
