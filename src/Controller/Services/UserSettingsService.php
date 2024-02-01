<?php

namespace App\Controller\Services;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserSettingsService extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SluggerInterface $slugger;

    public function __construct(EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $this->entityManager = $entityManager;
        $this->slugger = $slugger;
    }

    /*
     * editUser function uses a form which gets from UserController,
     * also gets user and checks if user wants to change his
     * profile image if no, just push to database string values.
     */
    public function editUser($form, User $user): void
    {
        $profileImageFile = $form->get('profile_picture')->getData();
        $bio = $form->get('bio')->getData();
        $phoneNumber = $form->get('phone_number')->getData();

        if ($profileImageFile) {
            $originalFileName = pathinfo($profileImageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFileName);
            $newFileName = $safeFilename . '-' . uniqid() . '.' . $profileImageFile->guessExtension();
            try {
                $profileImageFile->move(
                    $this->getParameter('profiles_directory'),
                    $newFileName);
                $user->setProfilePicture('images/users/' . $newFileName);
            } catch (FileException $e) {
                $user->setProfilePicture('images/nouser.jpg');
            }
        }
        $user->setPhoneNumber($phoneNumber);
        $user->setBio($bio);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}

