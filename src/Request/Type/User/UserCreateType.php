<?php

namespace App\Request\Type\User;

use App\Request\Type\AbstractType;

/**
 * Class UserCreateType
 * @package App\Request\Type
 */
class UserCreateType extends AbstractType
{
    /** @var mixed|null $email */
    public $email;

    /** @var mixed|null $fistName */
    public $firstName;

    /** @var mixed|null $lastName */
    public $lastName;

    /** @var mixed|null $activated */
    public $activated;

    /**
     * UserCreateType constructor.
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        $this->email = $fields['email'] ?? null;
        $this->firstName = $fields['first_name'] ?? null;
        $this->lastName = $fields['last_name'] ?? null;
        $this->activated = $fields['activated'] ?? null;
    }
}
