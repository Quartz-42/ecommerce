<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/"), name="homepage")
     */
    public function homePage(ProductRepository $productRepository)
    {
        $count = $productRepository->findAll();
        dd($count);

        return $this->render("home.html.twig");
    }
}
