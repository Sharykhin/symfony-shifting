<?php

namespace App\Factory;

use App\Contract\Factory\UserFactoryInterface;
use App\Entity\User;

/**
 * Class UserFactory
 * @package App\Factory
 */
class UserFactory implements UserFactoryInterface
{
    /**
     * @return User
     */
    public function create() : User
    {
        return new User();
    }
}
