<?php

namespace App\Controller\Services;

use App\Entity\User;
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
        SluggerInterface $slugger,
        EntityManagerInterface $entityManager) {

            $this->userPasswordHasher = $userPasswordHasher;
            $this->slugger = $slugger;
            $this->entityManager = $entityManager;
    }

    public function createUser($form, User $user): void
    {
        $profileImageFile = $form->get('profile_picture')->getData();
        if ($profileImageFile) {
            $originalFileName = pathinfo($profileImageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFileName);
            $newFileName = $safeFilename . '-' . uniqid() . '.' . $profileImageFile->guessExtension();
            try {
                $profileImageFile->move(
                    $this->getParameter('profiles_directory'),
                    $newFileName
                );
                $user->setProfilePicture('images/users/' . $newFileName);

            } catch (FileException $e) {
                $user->setProfilePicture('images/nouser.jpg');
            }
        }
        else {
            $user->setProfilePicture('images/nouser.jpg');
        }

        $user->setRoles(['ROLE_USER']);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setBio("no bio here");
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            )
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}