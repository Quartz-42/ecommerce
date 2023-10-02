<?php

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Service\StripeService;
use App\Repository\PurchaseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentController extends AbstractController
{
    #[Route('/purchase/pay/{id}', name: 'purchase_payment_form')]
    #[IsGranted('ROLE_USER')]

    public function showCardForm(int $id, PurchaseRepository $purchaseRepository, StripeService $stripeService)
    {
        $purchase = $purchaseRepository->find($id);
        $clientSecret = "sk_test_51Nuvx7LBiSBap6dTQ6ZjhjNisY1onrlrR7KkKPm7vBzNIhadx76ykDIFxhoGyERLfh9kO8RmrYTJGMcWKPmwIMGw001BdQvlE7";

        if (
            !$purchase
            || ($purchase && $purchase->getUsers() !== $this->getUser()
                || ($purchase && Purchase::STATUS_PAID === $purchase->getStatus()))
        ) {
            $this->addFlash('warning', 'La commande n\'existe pas');

            return $this->redirectToRoute('purchase_index');
        }

        $paymentIntent = $stripeService->getPaymentIntent($purchase);

        return $this->render('/purchase/payment.html.twig', [
            'clientSecret' => $clientSecret,
            'purchase' => $purchase,
        ]);
    }
}
