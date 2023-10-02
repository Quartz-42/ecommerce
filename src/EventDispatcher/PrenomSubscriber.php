<?php

namespace App\EventDispatcher;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PrenomSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'addPrenomToAttributes',
            'kernel.controller' => 'test1',
            'kernel.response' => 'test2',
        ];
    }

    public function addPrenomToAttributes(RequestEvent $requestEvent): void
    {
        $requestEvent->getRequest()->attributes->set('prenom', 'Ben');
    }

    public function test1()
    {
        dump('test1');
    }

    public function test2()
    {
        dump('test2');
    }
}
