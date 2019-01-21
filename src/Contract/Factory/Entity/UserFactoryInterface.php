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
     * @return User
     */
    public function create() : User;
}
