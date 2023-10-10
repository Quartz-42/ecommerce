<?php

namespace App\Controller\Cart;

use App\Repository\ProductRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class CartDecrementController extends AbstractController
{
    #[Route('/cart/decrement/{id}', name: 'cart_decrement', requirements: ['id' => '\d+'])]
    public function decrement(int $id, CartService $cartService, ProductRepository $productRepository): RedirectResponse
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas');
        }

        $cartService->decrement($id);
        $this->addFlash('success', 'La quantié a bien été ajustée');

        return $this->redirectToRoute('cart_show');
    }
}
