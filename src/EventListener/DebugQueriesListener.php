<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Doctrine\DBAL\Logging\SQLLogger;

/**
 * Class DebugQueriesListener
 * @package App\EventListener
 */
class DebugQueriesListener
{
    /** @var SQLLogger $logger */
    protected $logger;

    /**
     * AppResponseListener constructor.
     * @param SQLLogger $logger
     */
    public function __construct(SQLLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event): void
    {
        $response = $event->getResponse();

        if (strpos($response->headers->get('Content-Type'), 'application/json') === 0) {
            if (true === filter_var($event->getRequest()->get('_debug'), FILTER_VALIDATE_BOOLEAN)) {
                $jsonData = json_decode($response->getContent(), true);
                $jsonData['__debug'] = $this->logger->queries;
                $response->setContent(json_encode($jsonData));
            }
        }
    }
}
