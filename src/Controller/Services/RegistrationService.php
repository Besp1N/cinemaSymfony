<?php

namespace App\Controller\Services;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RegistrationService extends AbstractController
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private SluggerInterface $slugger;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher,
        SluggerInterface            $slugger,
        EntityManagerInterface      $entityManager)
    {

        $this->userPasswordHasher = $userPasswordHasher;
        $this->slugger = $slugger;
        $this->entityManager = $entityManager;
    }

    /*
     * createUser function creates a User, but before persist
     * function gets profile picture and makes unique fileName.
     * After make unique name it saves it in public/images, if there's no user picture
     * function sets nouser.jpg as default profile image
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
        $user->setRoles(['ROLE_USER']);
        $user->setCreatedAt(new DateTimeImmutable());
        $user->setBio("no bio here");
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}