<?php

namespace App\Controller\Cart;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartShowController extends AbstractController
{
    #[Route('/cart', name: 'cart_show')]
    public function show(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $detailedCart = [];
        $total = 0;

        foreach ($session->get('cart', []) as $id => $quantity) {
            $product = $productRepository->find($id);

            $detailedCart[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity,
            ];

            $total += ($product->getPrice() * $quantity) / 100;
        }

        return $this->render('cart/index.html.twig', [
            'items' => $detailedCart,
            'total' => $total,
        ]);
    }
}
