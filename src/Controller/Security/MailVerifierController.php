<?php

namespace App\Controller\Security;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailVerifierController extends AbstractController
{
    #[Route('/mail/verify/{id}', name: 'app_verify_mail')]
    public function verifyMail(UserRepository $userRepository, int $id): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $user->setIsVerified(true);
        $userRepository->save($user, true);

        return $this->redirectToRoute('app_login');
    }
}
