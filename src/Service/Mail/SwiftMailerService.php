<?php

namespace App\Service\Mail;

use App\Contract\Service\MailInterface;
use Swift_Message;
use Swift_Mailer;

/**
 * Class SwiftMailerService
 * @package App\Service\Mail
 */
class SwiftMailerService implements MailInterface
{
    /** @var Swift_Mailer $mailer */
    protected $mailer;

    /** @var Swift_Message $message */
    protected $message;

    /**
     * SwiftMailerService constructor.
     * @param Swift_Mailer $mailer
     * @param Swift_Message $message
     */
    public function __construct(Swift_Mailer $mailer, Swift_Message $message)
    {
        $this->mailer = $mailer;
        $this->message = $message;
    }

    /**
     * @param string $subject
     * @return SwiftMailerService
     */
    public function setSubject(string $subject): MailInterface
    {
        $this->message->setSubject($subject);

        return $this;
    }

    /**
     * @param $addresses
     * @param string|null $name
     * @return SwiftMailerService
     */
    public function setFrom($addresses, string $name = null): MailInterface
    {
       $this->message->setFrom($addresses, $name);

       return $this;
    }

    /**
     * @param $addresses
     * @param string|null $name
     * @return SwiftMailerService
     */
    public function setTo($addresses, string $name = null): MailInterface
    {
        $this->message->setTo($addresses, $name);

        return $this;
    }

    /**
     * @param string $body
     * @param string|null $contentType
     * @param null $charset
     * @return SwiftMailerService
     */
    public function setBody(string $body, string $contentType = null, $charset = null): MailInterface
    {
        $this->message->setBody($body, $contentType, $charset);

        return $this;
    }

    /**
     * @return void
     */
    public function send(): void
    {
        $this->mailer->send($this->message);
    }
}
