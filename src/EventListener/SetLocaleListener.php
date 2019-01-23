<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class SetLocaleListener
 * @package App\EventListener
 */
class SetLocaleListener
{
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event) : void
    {
        $request = $event->getRequest();

        if ($request->query->has('_locale')) {
            $request->setLocale($request->query->get('_locale'));
        }
    }
}
