<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function homePage()
    {
        /**
         * @Route("/"), name="homepage")
         */
        return $this->render("home.html.twig");
    }
}
