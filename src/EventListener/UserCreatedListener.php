<?php

namespace App\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Queue\Message\EmailMessage;
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

    /** @var MessageBusInterface $bus */
    protected $bus;

    /** @var ContainerInterface $container */
    protected $container;

    /**
     * UserCreatedListener constructor.
     * @param LoggerInterface $logger
     * @param MessageBusInterface $bus
     * @param ContainerInterface $container
     */
    public function __construct(
        LoggerInterface $logger,
        MessageBusInterface $bus,
        ContainerInterface $container
    )
    {
        $this->logger = $logger;
        $this->bus = $bus;
        $this->container = $container;
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

        $body = $this->container->get('twig')->render('emails/registration.html.twig', [
            'full_name' => $event->getUser()->getFullName()
        ]);

        $this->bus->dispatch(new EmailMessage('Thanks For Registration', $body, $event->getUser()->getEmail()));
    }
}
