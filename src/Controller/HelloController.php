<?php

namespace App\Controller;

use App\Taxes\Calculator;
use Cocur\Slugify\Slugify;
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

    public function hello($prenom, Slugify $slug)
    {
        dump($slug->slugify("Hello World"));
        $tva = $this->calculator->calcul(100);
        dd($tva);
        //phpinfo();
        return new Response("Hello $prenom");
    }
}
