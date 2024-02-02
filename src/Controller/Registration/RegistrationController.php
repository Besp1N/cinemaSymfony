<?php

namespace App\Controller\Registration;

use App\Controller\Services\EmailService;
use App\Controller\Services\RegistrationService;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class RegistrationController extends AbstractController
{

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/register', name: 'app_register', priority: 4)]
    public function register(RegistrationService $registrationService, Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        /*
        * form validation and registrationService->createUser() is making a User
        * at last we are redirected to app_login path to log into new account
        */
        if ($form->isSubmitted() && $form->isValid()) {

            $registrationService->createUser($form, $user);
            $this->addFlash('success', 'You have registered your account. Now log in:)');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
