<?php

namespace App\Contract\Service;

interface MailInterface
{
    public function setSubject($subject) : self;

    public function setFrom($addresses, $name = null) : self;

    public function setTo($addresses, $name = null) : self;

    public function setBody($body, $contentType = null, $charset = null): self;

    public function send() : void;
}