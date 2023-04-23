<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    public function index()
    {
        dd("Ca fonctionne");
    }

    // !!!!!!!!!!!le @Route ne va pas marcher de base avec PHP car c'est un commentaire, PHP ne le lit pas. il faut installer des packages supplémentaires, voir sympfony flex!!!!!!!!!!!!!!

    /**
     * @Route("/test/{age<\d+>?0}", name="test", methods={"GET", "POST"}, host="localhost",schemes={"https", "http"})
     */
    public function test($age)
    {
        //on passe en parametre Request $request pour eviter d'ecrire la ligne suivante
        // $request = Request::createFromGlobals();

        //on utilise la librairie FOUNDATION de symfony pour remplacer ce bout de code par 
        // $age = 0;
        // if (!empty($_GET['age'])) {
        //     $age = $_GET['age'];
        // }

        //dd($request);
        // $age = $request->attributes->get('age');


        return new Response("Vous avez $age ans");
        //dd("Vous avez $age ans");
    }
}
