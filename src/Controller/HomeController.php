<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homePage(ProductRepository $productRepository): Response
    {
        $maxResults = 3;
        $products = $productRepository->findLatestProducts($maxResults);

        return $this->render("home.html.twig", [
            'products' => $products,
        ]);
    }
}
