<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Rates;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RateController extends AbstractController
{
    #[Route('/rate/{movie}/{rating}', name: 'app_rate', priority: 10)]
    public function index(Request $request, Movie $movie, int $rating, EntityManagerInterface $entityManager): RedirectResponse
    {
        $referer = $request->headers->get('referer');
        $expectedReferer = $this->generateUrl('app_home_movie', ['movie' => $movie->getId()], true);
        if ($referer !== $expectedReferer) {
            throw $this->createAccessDeniedException('Invalid referer');
        }

        $user = $this->getUser();
        $rate = new Rates();
        $rate->setRate((int)$rating);
        $rate->setMovie($movie);
        $rate->setUser($user);

        $entityManager->persist($rate);
        $entityManager->flush();

        return $this->redirectToRoute('app_home_movie', [
            'movie' => $movie->getId()
        ]);


    }
}
