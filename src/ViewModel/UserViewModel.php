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
     * @Groups({"private"})
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
     * @param int $id
     * @return UserViewModel
     */
    public function setId(int $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param string $fullName
     * @return UserViewModel
     */
    public function setFullName(string $fullName) : self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFullName() : string
    {
        return $this->fullName;
    }

    /**
     * @param string $email
     * @return UserViewModel
     */
    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param DateTimeImmutable|null $dateTimeImmutable
     * @return UserViewModel
     */
    public function setActivated(?DateTimeImmutable $dateTimeImmutable) : self
    {
        $this->activated = $dateTimeImmutable;

        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getActivated() : ?DateTimeImmutable
    {
        return $this->activated;
    }
}
