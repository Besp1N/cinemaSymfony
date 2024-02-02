<?php

namespace App\Controller\Services;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class EmailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendConfirmationEmail(): void
    {
        $email = (new Email())
            ->from(new Address('symfonycinema@wp.pl', 'Symfony Cinema')) // Adres i nazwa nadawcy
            ->to('symfonycinema@wp.pl')
            ->subject('Potwierdź swoje konto')
            ->text('dupa');

        $this->mailer->send($email);
    }
}