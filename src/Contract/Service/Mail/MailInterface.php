<?php

namespace App\Contract\Service\Mail;

/**
 * Interface MailInterface
 * @package App\Contract\Service
 */
interface MailInterface
{
    /**
     * @param string $subject
     * @return mixed
     */
    public function setSubject(string $subject): self;

    /**
     * @param $addresses
     * @param string|null $name
     * @return MailInterface
     */
    public function setFrom($addresses, string $name = null): self;

    /**
     * @param $addresses
     * @param string|null $name
     * @return MailInterface
     */
    public function setTo($addresses, string $name = null): self;

    /**
     * @param string $body
     * @param string|null $contentType
     * @param null $charset
     * @return MailInterface
     */
    public function setBody(string $body, string $contentType = null, $charset = null): self;

    /**
     * @return mixed
     */
    public function send(): void;
}