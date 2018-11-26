<?php

namespace App\Contract\Factory;

use App\Entity\User;

/**
 * Interface UserFactoryInterface
 * @package App\Contract\Factory
 */
interface UserFactoryInterface
{
    /**
     * @return User
     */
    public function create() : User;
}
