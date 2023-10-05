<?php

namespace App\EventDispatcher;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class PrenomSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'addPrenomToAttributes',
        ];
    }

    public function addPrenomToAttributes(RequestEvent $requestEvent): void
    {
        $requestEvent->getRequest()->attributes->set('prenom', 'Ben');
    }
}
