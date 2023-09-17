<?php

namespace App\Controller\Product;

use App\Entity\Product;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowController extends AbstractController
{
    #[Route('/{category_slug}/{slug}', name: 'product_show')]
    public function show(Product $product)
    {
        if (!$product) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
