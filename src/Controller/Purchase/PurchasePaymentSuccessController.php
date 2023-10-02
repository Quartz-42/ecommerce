<?php

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Service\CartService;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentSuccessController extends AbstractController
{
    #[Route('/purchase/terminate/{id}', name: 'purchase_success')]
    #[IsGranted('ROLE_USER')]
    public function success($id, PurchaseRepository $purchaseRepository, EntityManagerInterface $em, CartService $cartService)
    {
        $purchase = $purchaseRepository->find($id);

        if (
            !$purchase
            || ($purchase && $purchase->getUsers() !== $this->getUser()
                || ($purchase && Purchase::STATUS_PAID === $purchase->getStatus()))
        ) {
            $this->addFlash('warning', 'La commande n\'existe pas');

            return $this->redirectToRoute('purchase_index');
        }

        $purchase->setStatus(Purchase::STATUS_PAID);

        $em->flush();

        $cartService->empty();

        $this->addFlash('success', 'La commande a bien été payée');

        return $this->redirectToRoute('purchase_index');
    }
}
