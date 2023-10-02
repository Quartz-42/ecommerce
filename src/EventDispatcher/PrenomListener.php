<?php

namespace App\EventDispatcher;

use Symfony\Component\HttpKernel\Event\RequestEvent;

class PrenomListener
{
    public function addPrenomToAttributes(RequestEvent $requestEvent): void
    {
        $requestEvent->getRequest()->attributes->set('prenom', 'Ben');
    }
}
