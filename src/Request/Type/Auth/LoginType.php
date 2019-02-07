<?php

namespace App\Request\Type\Auth;

use App\Request\Type\AbstractType;

/**
 * Class LoginType
 * @package App\Request\Type\Auth
 */
class LoginType extends AbstractType
{
    /** @var string|null $email */
    public $email;

    /** @var string|null $password */
    public $password;

    /**
     * LoginType constructor.
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        $this->email = $fields['email'] ?? null;
        $this->password = $fields['password'] ?? null;
    }
}
