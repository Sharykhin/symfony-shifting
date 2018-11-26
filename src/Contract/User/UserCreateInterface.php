<?php

namespace App\Contract\User;

use App\Entity\User;

/**
 * Interface UserCreateInterface
 * @package App\Contract\User
 */
interface UserCreateInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data) : User;
}
