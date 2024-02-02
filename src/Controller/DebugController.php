<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class DebugController extends AbstractController
{
    #[Route('/debug', name: 'app_debug', priority: 12)]
    public function index(): Response
    {
       $transport = Transport::fromDsn('smtp://cinemasymfony@gmail.com:zkuhwetkhptibbnk@smtp.gmail.com:587');

       $mailer = new Mailer($transport);

       $email = (new Email());

       $email->from('cinemasymfony@gmail.com');

       $email->to(
           'cinemasymfony@gmail.com'
       );

       $email->subject('subject');

       $email->text('dupa');

       $email->html('<h1>This is my mail!</h1>');

       $mailer->send($email);

       return new Response('chyba dziala');
    }

}
