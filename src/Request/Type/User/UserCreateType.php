<?php

namespace App\Request\Type\User;

use App\Request\Type\AbstractType;

/**
 * Class UserCreateType
 * @package App\Request\Type
 */
class UserCreateType extends AbstractType
{
    /** @var string|null $email */
    public $email;

    /** @var string|null $fistName */
    public $firstName;

    /** @var string|null $lastName */
    public $lastName;

    /** @var mixed|null $activated */
    public $activated;

    /** @var string|null $password */
    public $password;

    /** @var array|null  */
    public $roles;

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
        $this->password = $fields['password'] ?? null;
        $this->roles = $fields['roles'] ?? null;
    }
}
