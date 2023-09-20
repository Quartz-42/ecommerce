<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\Type\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    protected MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $userRepository->save($user, true);

            $email = (new TemplatedEmail())
                ->from('benjamin.baroche@free.fr')
                ->to($user->getEmail())
                ->replyTo('contact@mail.com')
                ->subject('Confirmez votre inscription')
                ->text('Bonne nouvelles en vue !')
                ->htmlTemplate('/registration/confirmation_email.html.twig')
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'mail' => $user->getEmail(),
                    'id' => $user->getId(),
                ]);
            $this->mailer->send($email);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
