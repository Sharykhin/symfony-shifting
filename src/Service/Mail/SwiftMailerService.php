<?php

namespace App\Service\Mail;

use App\Contract\Service\MailInterface;
use Swift_Mailer;

class SwiftMailerService implements MailInterface
{
    protected $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function setSubject($subject): MailInterface
    {
        // TODO: Implement setSubject() method.
    }

    public function setFrom($addresses, $name = null): MailInterface
    {
        // TODO: Implement setFrom() method.
    }

    public function setTo($addresses, $name = null): MailInterface
    {
        // TODO: Implement setTo() method.
    }

    public function setBody($body, $contentType = null, $charset = null): MailInterface
    {
        // TODO: Implement setBody() method.
    }

    public function send(): void
    {
        // TODO: Implement send() method.
    }
}