<?php

namespace App\ViewModel;

/**
 * Class UserViewModel
 * @package App\ViewModel
 */
class UserViewModel
{
    /** @var int $id */
    protected $id;

    /** @var string $fullName */
    protected $fullName;

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
    public function getId() : ?int
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
    public function getFullName() : ?string
    {
        return $this->fullName;
    }
}
