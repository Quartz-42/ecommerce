<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homePage(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $maxResults = 3;
        $products = $productRepository->findLatestProducts($maxResults);

        $categories = $categoryRepository->findAll();

        return $this->render('home.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
