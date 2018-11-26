<?php

namespace App\Request\User;

/**
 * Class UserCreateRequest
 * @package App\Request\User
 */
class UserCreateRequest
{
    /** @var mixed|null $email */
    public $email;

    /** @var mixed|null $firstName */
    public $firstName;

    /** @var mixed|null $lastName */
    public $lastName;

    /**
     * UserCreateRequest constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->email = $data['email'] ?? null;
        $this->firstName = $data['first_name'] ?? null;
        $this->lastName = $data['last_name'] ?? null;
    }
}