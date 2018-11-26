<?php

namespace App\EventListener;

use function json_last_error;
use function json_last_error_msg;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ParseJsonBodyListener
 * @package App\EventListener
 */
class ParseJsonBodyListener
{
    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event) : void
    {
        $request = $event->getRequest();
        if ($request->getContentType() != 'json' || !$request->getContent()) {
            return;
        }
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('invalid json body: ' . json_last_error_msg());
        }
        $request->request->replace(is_array($data) ? $data : array());
    }
}