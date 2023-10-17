<?php

namespace App\Mailer;

use App\Entity\Purchase;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ConfirmationMail
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendConfirmationMail(string $mailUser, array $purchasedItems, Purchase $purchase): void
    {
        $email = (new TemplatedEmail())
            ->from('benjamin.baroche@free.fr')
            ->to($mailUser)
            ->replyTo('contact@mail.com')
            ->subject('Confirmation de votre commande')
            ->text('Bonne nouvelle en vue !')
            ->htmlTemplate('/purchase/purchase_confirmation_email.html.twig')
            ->context([
                'purchasedItems' => $purchasedItems,
                'purchase' => $purchase,
            ]);

        $this->mailer->send($email);
    }
}
