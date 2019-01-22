<?php

namespace App\Queue\Message;

/**
 * Class EmailMessage
 * @package App\Queue\Message
 */
class EmailMessage
{
    /** @var string $subject */
    protected $subject;

    /** @var string $body */
    protected $body;

    /** @var string $to */
    protected $to;

    /** @var string|null $name */
    protected $name;

    /** @var string $contentType */
    protected $contentType;

    /**
     * EmailMessage constructor.
     * @param string $subject
     * @param string $body
     * @param string $to
     * @param string|null $name
     * @param string $contentType
     */
    public function __construct(
        string $subject,
        string $body,
        string $to,
        string $name = null,
        string $contentType ='text/html'
    )
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->to = $to;
        $this->name = $name;
        $this->contentType = $contentType;
    }

    /**
     * @return string
     */
    public function getSubject() : string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getTo() : string
    {
        return $this->to;
    }

    /**
     * @return null|string
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getContentType() : string
    {
        return $this->contentType;
    }
}
