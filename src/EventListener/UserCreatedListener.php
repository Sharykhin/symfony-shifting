<?php

namespace App\EventListener;

use App\Event\UserCreatedEvent;
use Psr\Log\LoggerInterface;

/**
 * Class UserCreatedListener
 * @package App\EventListener
 */
class UserCreatedListener
{
    /** @var LoggerInterface $logger */
    protected $logger;

    /**
     * UserCreatedListener constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param UserCreatedEvent $event
     */
    public function onUserCreated(UserCreatedEvent $event) : void
    {
        $this->logger->info(sprintf(
            'User %s has been created with ID: %d',
            $event->getUser()->getFullName(),
            $event->getUser()->getId()
        ));
    }
}
