<?php

namespace App\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Doctrine\DBAL\Logging\SQLLogger;

/**
 * Class EnableDebugQueriesListener
 * @package App\EventListener
 */
class EnableDebugQueriesListener
{
    /** @var ContainerInterface $container */
    protected $container;

    /** @var SQLLogger $logger */
    protected $logger;

    /**
     * AppRequestListener constructor.
     * @param ContainerInterface $container
     * @param SQLLogger $logger
     */
    public function __construct(
        ContainerInterface $container,
        SQLLogger $logger
    )
    {
        $this->container = $container;
        $this->logger = $logger;
    }
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        $this->container->get('doctrine')->getConnection()
            ->getConfiguration()
            ->setSQLLogger($this->logger);
    }
}
