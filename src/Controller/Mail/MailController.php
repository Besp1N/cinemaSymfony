<?php

namespace App\Controller\Mail;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    #[Route('mail/{token}', name: 'app_mail', methods: ['GET'])]
    public function index(string $token, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->findOneBy(['activationToken' => $token]);

        if (!$user) {
            throw $this->createNotFoundException('Invalid activation token');
        }

        $user->setIsActive(true);
        $user->setActivationToken("chuj");

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Your account has been activated. You can now log in.');

        return $this->redirectToRoute('app_login');
    }
}
