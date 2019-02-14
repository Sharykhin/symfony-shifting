<?php

namespace App\Contract\Factory\Entity;

use App\Entity\User;

/**
 * Interface UserFactoryInterface
 * @package App\Contract\Factory
 */
interface UserFactoryInterface
{
    /**
     * Creates a new User entity
     *
     * @return User
     */
    public function create(): User;
}
