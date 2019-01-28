<?php

namespace App\ViewModel;

use Symfony\Component\Serializer\Annotation\Groups;
use DateTimeImmutable;

/**
 * Class UserViewModel
 * @package App\ViewModel
 */
class UserViewModel
{
    /**
     * @var int $id
     *
     * @Groups({"public", "private"})
     */
    protected $id;

    /**
     * @var string $fullName
     *
     * @Groups({"public", "private"})
     */
    protected $fullName;

    /**
     * @var string $email
     *
     * @Groups({"public", "private"})
     */
    protected $email;

    /**
     * @var DateTimeImmutable|null $activated
     *
     * @Groups({"private"})
     */
    protected $activated;

    /**
     * @var int $invoices
     *
     * @Groups({"public", "private"})
     */
    protected $invoices;

    /**
     * @var float $totalAmount
     *
     * @Groups({"public", "private"})
     */
    protected $totalAmount;

    /**
     * UserViewModel constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->fullName = $data['full_name'];
        if (isset($data['activated']) && is_string($data['activated'])) {
            $this->activated = new DateTimeImmutable($data['activated']);
        } else {
            $this->activated = $data['activated'] ?? null;
        }

        $this->invoices = $data['invoices'];
        $this->totalAmount = $data['total_amount'];
    }

    /**
     * @return int|null
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getActivated(): ?DateTimeImmutable
    {
        return $this->activated;
    }

    /**
     * @return int
     */
    public function getInvoices(): int
    {
        return $this->invoices;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }
}
