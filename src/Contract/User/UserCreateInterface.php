<?php

namespace App\Contract\User;

use App\Entity\User;
use App\Request\User\UserCreateRequest;

/**
 * Interface UserCreateInterface
 * @package App\Contract\User
 */
interface UserCreateInterface
{
    /**
     * @param UserCreateRequest $request
     * @return User
     */
    public function create(UserCreateRequest $request) : User;
}
