<?php

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Service\StripeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PurchasePaymentController extends AbstractController
{
    #[Route('/purchase/pay/{id}', name: 'purchase_payment_form')]
    #[IsGranted('ROLE_USER')]
    public function showCardForm(Purchase $purchase, StripeService $stripeService): Response
    {
        $clientSecret = 'sk_test_51Nuvx7LBiSBap6dTQ6ZjhjNisY1onrlrR7KkKPm7vBzNIhadx76ykDIFxhoGyERLfh9kO8RmrYTJGMcWKPmwIMGw001BdQvlE7';

        if (
            /* @phpstan-ignore-next-line */
            $purchase && $purchase->getUsers() !== $this->getUser() /* @phpstan-ignore-line */
                || ($purchase && Purchase::STATUS_PAID === $purchase->getStatus()) /* @phpstan-ignore-line */
        ) {
            $this->addFlash('warning', 'La commande n\'existe pas');

            return $this->redirectToRoute('purchase_index');
        }

        $stripeService->getPaymentIntent($purchase);

        return $this->render('/purchase/payment.html.twig', [
            'clientSecret' => $clientSecret,
            'purchase' => $purchase,
        ]);
    }
}
