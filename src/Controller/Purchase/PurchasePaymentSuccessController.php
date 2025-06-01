<?php

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PurchasePaymentSuccessController extends AbstractController
{
    #[Route('/purchase/terminate/{id}', name: 'purchase_payment_success')]
    #[IsGranted('ROLE_USER')]
    public function success(Purchase $purchase, EntityManagerInterface $em, CartService $cartService): RedirectResponse
    {
        if (
            /* @phpstan-ignore-next-line */
            $purchase && $purchase->getUsers() !== $this->getUser() /* @phpstan-ignore-line */
                || ($purchase && Purchase::STATUS_PAID === $purchase->getStatus()) /* @phpstan-ignore-line */
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
