<?php

namespace App\Controller;

use App\Taxes\Calculator;
use App\Taxes\Detector;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ControllerHello extends AbstractController
{

    protected $twig;
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    // protected $calculator;

    // public function __construct(Calculator $calculator)
    // {
    //     $this->calculator = $calculator;
    // }
    /**
     * @Route("/hello/{prenom?World}", name="hello", methods={"GET", "POST"}, host="localhost", schemes={"https", "http"})
     */

    // public function hello($prenom = "World")
    // {

    //     // dump($detector->detect(150));
    //     // dump($detector->detect(20));

    //     // dump($twig);

    //     // dump($slug->slugify("Hello World"));
    //     // $tva = $this->calculator->calcul(100);
    //     // dd($tva);
    //     // // phpinfo();
    //     //return new Response("Hello $prenom");

    //     //*********************ESSAI TWIG ******************************* */
    //     $html = $this->twig->render("hello.html.twig", [
    //         //on passe un tableau associatif pour lui dire quelles variables utiliser
    //         "prenom" => $prenom,
    //         "age" => 36,
    //         "prenoms" => [
    //             "Ben",
    //             "John",
    //             "Vince"
    //         ]
    //     ]);
    //     return new Response($html);
    // }

    /**
     * @Route("/testTwig", name="hello")
     */

    public function testTwig()
    {
        return $this->render("test.html.twig", [
            "age" => 36
        ]);
    }
}
