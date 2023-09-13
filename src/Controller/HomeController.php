<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homePage(ProductRepository $productRepository): Response
    {
        $maxResults = 3;
        $products = $productRepository->findLatestProducts($maxResults);

        return $this->render('home.html.twig', [
            'products' => $products,
        ]);
    }
}
