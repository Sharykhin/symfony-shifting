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
     * InvoiceViewModel constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->amount = $data['amount'];
        $this->comment = $data['comment'];
        if (isset($data['created_at']) && is_string($data['created_at'])) {
            $this->createdAt = new DateTimeImmutable($data['created_at']);
        } else {
            $this->createdAt = new DateTimeImmutable('now');
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
