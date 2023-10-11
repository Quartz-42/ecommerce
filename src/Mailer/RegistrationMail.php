<?php

namespace App\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class RegistrationMail extends AbstractController
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendRegisterMail(string $mailUser, int $idUser): void
    {
        $email = (new TemplatedEmail())
            ->from('benjamin.baroche@free.fr')
            ->to($mailUser)
            ->replyTo('contact@mail.com')
            ->subject('Confirmez votre inscription')
            ->text('Bonne nouvelle en vue !')
            ->htmlTemplate('/registration/confirmation_email.html.twig')
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'mail' => $mailUser,
                'id' => $idUser,
            ]);

        $this->mailer->send($email);
    }
}
