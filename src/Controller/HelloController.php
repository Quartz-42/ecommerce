<?php

namespace App\ControllerTest;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerHello
{
    /**
     * @Route("/hello{prenom, world}", name="hello", methods={"GET"}, host="localhost", schemes={"https,https"})
     */


    public function hello($prenom)
    {
        return new Response("Hello $prenom");
    }
}
