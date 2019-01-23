<?php

namespace App\ViewModel;

use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeImmutable;

/**
 * Class InvoiceViewModel
 * @package App\ViewModel
 */
class InvoiceViewModel
{
    /**
     * @var int $id
     *
     * @Groups({"public"})
     */
    protected $id;

    /**
     * @var float $amount
     *
     * @Groups({"public"})
     */
    protected $amount;

    /**
     * @var string|null $comment
     *
     * @Groups({"public"})
     */
    protected $comment;

    /**
     * @var DateTimeImmutable $createdAt
     *
     * @Groups({"public"})
     */
    protected $createdAt;

    /**
     * @param int $id
     * @return InvoiceViewModel
     */
    public function setId(int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param float $amount
     * @return InvoiceViewModel
     */
    public function setAmount(float $amount) : self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount() : float
    {
        return $this->amount;
    }

    /**
     * @param string|null $comment
     * @return $this
     */
    public function setComment(string $comment = null)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment() : ?string
    {
        return $this->comment;
    }

    /**
     * @param DateTimeImmutable $createdAt
     * @return InvoiceViewModel
     */
    public function setCreatedAt(DateTimeImmutable $createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt() : DateTimeImmutable
    {
        return $this->createdAt;
    }
}
