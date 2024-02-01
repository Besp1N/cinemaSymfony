<?php

namespace App\Controller\User;

use App\Controller\Services\UserSettingsService;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{
    #[Route('/user/{user}', name: 'app_user', priority: 5)]
    public function index(User $user): Response
    {
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'reservations' => $user->getReservations(),
            'achievements' => $user->getUserAchievements()
        ]);
    }

    #[Route('/user/settings', name: 'app_user_settings', priority: 6)]
    public function userSettings(
        Request $request,
        UserSettingsService $userSettingsService
    ): Response {

        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid() and $user instanceof User) {

            $userSettingsService->editUser($form, $user);
            return $this->redirectToRoute('app_user', [
                'user' => $user->getId()
            ]);
        }

        return $this->render('user/userSettings.html.twig', [
           'user' => $user,
            'SettingsForm' => $form
        ]);
    }
}
