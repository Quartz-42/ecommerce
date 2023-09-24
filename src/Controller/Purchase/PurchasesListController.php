<?php

namespace App\Controller\Purchase;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PurchasesListController extends AbstractController
{
    protected $security;

    public function __construct(Security $security)
    {
        $this->security =  $security;
    }

    #[Route('/purchases', name: 'purchase_index')]
    public function index(): Response
    {
        /**@var User */
        $user = $this->security->getUser();

        if (!$user) {
            throw new AccessDeniedException('Vous devez être connecté pour accéder à vos commandes');
        }

        return $this->render('purchase/index.html.twig', [
            'purchases' => $user->getPurchases(),
            'name' => $user->getEmail(),
        ]);
    }
}
