<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart/add/{id}', name: 'cart_add', requirements: ['id' => '\d+'])]
    public function add($id, ProductRepository $productRepository, SessionInterface $session): Response
    {
        // sécurisation du panier
        $product = $productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas');
        }

        // on cherche le panier dans la session, s'il n'existe pas on le crée
        $cart = $session->get('cart', []);

        // on regarde si le produit est déjà dans le panier
        // si oui : on augmente la quantité de 1
        // si non : on l'ajoute avec une quantité à 1
        if (array_key_exists($id, $cart)) {
            ++$cart[$id];
        } else {
            $cart[$id] = 1;
        }

        // on enregistre le panier à jour dans la session
        $session->set('cart', $cart);
        $this->addFlash('success', 'Le produit a bien été ajouté au panier');

        return $this->redirectToRoute('product_show', [
            'category_slug' => $product->getCategory()->getSlug(),
            'slug' => $product->getSlug(),
        ]);
    }
}
