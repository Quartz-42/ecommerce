<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerHello
{
    // protected $logger;

    // public function __construct(LoggerInterface $logger)
    // {
    //     $this->logger = $logger;
    // }
    /**
     * @Route("/hello/{prenom?World}", name="hello", methods={"GET", "POST"}, host="localhost", schemes={"https", "http"})
     */

    public function hello($prenom)
    {
        // $this->logger->info("mon msg de log");
        return new Response("Hello $prenom");
    }
}
