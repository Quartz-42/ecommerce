<?php

namespace App\Controller;

use App\Taxes\Calculator;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerHello
{
    protected $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }
    /**
     * @Route("/hello/{prenom?World}", name="hello", methods={"GET", "POST"}, host="localhost", schemes={"https", "http"})
     */

    public function hello($prenom)
    {
        $tva = $this->calculator->calcul(100);
        return new Response("Hello $prenom");
        dd($tva);
    }
}
