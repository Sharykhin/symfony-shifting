<?php

namespace App\Queue\Handler;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Contract\Service\Mail\MailInterface;
use App\Queue\Message\EmailMessage;

/**
 * Class EmailMessageHandler
 * @package App\Queue\Handler
 */
class EmailMessageHandler implements MessageHandlerInterface
{
    /** @var MailInterface $mail */
    protected $mail;

    /** @var ContainerInterface $container */
    protected $container;

    /**
     * EmailMessageHandler constructor.
     * @param MailInterface $mail
     * @param ContainerInterface $container
     */
    public function __construct(
        MailInterface $mail,
        ContainerInterface $container
    )
    {
        $this->mail = $mail;
        $this->container = $container;
    }

    /**
     * @param EmailMessage $message
     */
    public function __invoke(EmailMessage $message) : void
    {
        $this->mail->setSubject($message->getSubject())
            ->setFrom(
                $this->container->getParameter('mailer_from_mail'),
                $this->container->getParameter('mailer_from_name')
            )
            ->setTo($message->getTo(), $message->getName())
            ->setBody($message->getBody(), $message->getContentType())
            ->send();

        echo 'sent message to ' . $message->getTo() . PHP_EOL;
    }
}
