<?php

namespace App\ControllerTest;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerHello
{
    /**
     * @Route("/hello/{prenom?world}", name="hello", methods={"GET", "POST"}, host="localhost", schemes={"https","http"})
     */

    public function hello($prenom)
    {
        return new Response("Hello $prenom");
    }
}
