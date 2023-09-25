<?php

namespace App\Controller\Purchase;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PurchasesListController extends AbstractController
{
    #[Route('/purchases', name: 'purchase_index')]
    #[IsGranted('ROLE_USER', message: 'Vous devez être connecté pour accéder à vos commandes')]
    public function index(): Response
    {
        /** @var User */
        $user = $this->getUser();

        return $this->render('purchase/index.html.twig', [
            'purchases' => $user->getPurchases(),
            'name' => $user->getEmail(),
        ]);
    }
}
