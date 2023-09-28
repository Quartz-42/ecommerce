<?php

namespace App\Controller\Purchase;

use Stripe\Stripe;
use App\Entity\Purchase;
use App\Repository\PurchaseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentController extends AbstractController
{
    #[Route('/purchase/pay/{id}', name: 'purchase_payment_form')]
    #[IsGranted('ROLE_USER')]

    public function showCardForm(int $id, PurchaseRepository $purchaseRepository)
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

        Stripe::setApiKey($this->getParameter("stripe_secret_key"));

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price' => $purchase->getId(),
                'quantity' => $purchase->getTotal(),
            ]],
            'mode' => 'payment',
            'success_url' => 'https://localhost:800/purchase/terminate/' . $purchase->getId(),
            'cancel_url' => 'https://localhost:800/purchase/cancel',
        ]);
        return new RedirectResponse($checkout_session->url);
    }
}
