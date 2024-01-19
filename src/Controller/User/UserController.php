<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{user}', name: 'app_user', priority: 5)]
    public function index(User $user): Response
    {
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'reservations' => $user->getReservations()
        ]);
    }

    #[Route('/user/settings', name: 'app_user_settings', priority: 6)]
    public function userSettings(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $phoneNumber = $form->get('phone_number')->getData();
            $bio = $form->get('bio')->getData();

            $user->setPhoneNumber($phoneNumber);
            $user->setBio($bio);

            $entityManager->persist($user);
            $entityManager->flush();

            // narazie bez flash
            // $this->addFlash('success', 'Your settings have been updated successfully.');

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
