<?php

namespace App\Controller\Category;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    #[Route('/category/edit', name: 'app_category_edit')]
    public function edit(): Response
    {
        return $this->render('category/edit/index.html.twig', [
            'controller_name' => 'EditController',
        ]);
    }
}
