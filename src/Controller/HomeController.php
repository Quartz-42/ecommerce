<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/"), name="homepage")
     */
    public function homePage(EntityManagerInterface $em)
    {

        $productRepository = $em->getRepository(Product::class);

        $product = $productRepository->find(5);
        $em->remove($product);
        $em->flush();

        return $this->render("home.html.twig");
    }
}
