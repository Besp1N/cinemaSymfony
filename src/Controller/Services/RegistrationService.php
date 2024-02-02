<?php

namespace App\Controller\Services;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


class RegistrationService extends AbstractController
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private SluggerInterface $slugger;
    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;

    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher,
        SluggerInterface            $slugger,
        EntityManagerInterface      $entityManager,
        MailerInterface             $mailer)
    {

        $this->userPasswordHasher = $userPasswordHasher;
        $this->slugger = $slugger;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    /*
     * createUser function creates a User, but before persist
     * function gets profile picture and makes unique fileName.
     * After make unique name it saves it in public/images, if there's no user picture
     * function sets nouser.jpg as default profile image
     */
    /**
     * @throws TransportExceptionInterface
     */
    public function createUser($form, User $user): void
    {
        $profileImageFile = $form->get('profile_picture')->getData();

        // if there is profile image, save logic will be executed
        if ($profileImageFile) {
            $originalFileName = pathinfo($profileImageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFileName);
            $newFileName = $safeFilename . '-' . uniqid() . '.' . $profileImageFile->guessExtension();

            // try catch block if there's an error during the saving user picture
            try {
                $profileImageFile->move($this->getParameter('profiles_directory'), $newFileName);
                $user->setProfilePicture('images/users/' . $newFileName);
            } catch (FileException $e) {
                $user->setProfilePicture('images/nouser.jpg');
            }
        } else {
            $user->setProfilePicture('images/nouser.jpg');
        }

        // saving an User in database and hash password
        $activationToken = md5(uniqid());
        $user->setRoles(['ROLE_USER']);
        $user->setCreatedAt(new DateTimeImmutable());
        $user->setBio("no bio here");
        $user->setIsActive(false);
        $user->setActivationToken($activationToken);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->sendActivationMail($user, $activationToken);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendActivationMail(User $user, $activationToken): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('cinemasymfony@gmail.com', 'Symfony Cinema'))
            ->to('cinemasymfony@gmail.com')
            ->subject('Aktywacja konta')
            ->htmlTemplate('email/confirmation_email.html.twig')
            ->context([
                'user' => $user,
                'token' => $activationToken,
            ]);

        $this->mailer->send($email);
    }
}