<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    protected $session;
    protected $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->session = $requestStack->getSession();
        $this->productRepository = $productRepository;
    }

    protected function getCart(): array
    {
        return $this->session->get('cart', []);
    }

    protected function saveCart(array $cart)
    {
        return $this->session->set('cart', $cart);
    }

    public function add(int $id)
    {
        // on cherche le panier dans la session, s'il n'existe pas on le crée
        $cart = $this->getCart();

        // on regarde si le produit est déjà dans le panier
        // si oui : on augmente la quantité de 1
        // si non : on l'ajoute avec une quantité à 1
        if (!array_key_exists($id, $cart)) {
            $cart[$id] = 0;
        }

        ++$cart[$id];

        // on enregistre le panier à jour dans la session
        $this->saveCart($cart);
    }

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getCart() as $id => $quantity) {
            $product = $this->productRepository->find($id);

            if (!$product) {
                continue;
            }

            $total += ($product->getprice() * $quantity / 100);
        }

        return $total;
    }

    public function getDetailedCartItems(): array
    {
        $detailedCart = [];

        foreach ($this->getCart() as $id => $quantity) {
            $product = $this->productRepository->find($id);

            if (!$product) {
                continue;
            }

            $detailedCart[] = new CartItem($product, $quantity);
        }

        return $detailedCart;
    }

    public function remove(int $id)
    {
        $cart = $this->getCart();

        unset($cart[$id]);

        $this->saveCart($cart);
    }

    public function decrement(int $id)
    {
        $cart = $this->getCart();

        if (array_key_exists($id, $cart)) {
            if (1 === $cart[$id]) {
                $this->remove($id);

                return;
            }

            $cart[$id]--;

            $this->saveCart($cart);
        }
    }
}