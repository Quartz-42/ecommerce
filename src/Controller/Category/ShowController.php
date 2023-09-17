<?php

namespace App\Controller\Category;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowController extends AbstractController
{
    #[Route('/category/{slug}', name: 'product_category')]
    public function category(Category $category): Response
    {
        if (!$category) {
            throw $this->createNotFoundException("La catégorie demandée n'existe pas");
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
