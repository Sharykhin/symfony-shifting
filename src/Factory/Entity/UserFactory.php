<?php

namespace App\Factory\Entity;

use App\Contract\Factory\Entity\UserFactoryInterface;
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
