<?php

namespace App\Controller\Cart;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartShowController extends AbstractController
{
    #[Route('/cart', name: 'cart_show')]
    public function show(CartService $cartService): Response
    {
        $detailedCart = $cartService->getDetailedCartItems();

        $total = $cartService->getTotal();

        return $this->render('cart/cart_view.html.twig', [
            'items' => $detailedCart,
            'total' => $total,
        ]);
    }
}
