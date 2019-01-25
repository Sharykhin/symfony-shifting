<?php

namespace App\Contract\Service\User;

use App\Request\Type\User\UserCreateType;
use App\ViewModel\UserViewModel;

/**
 * Interface UserCreateInterface
 * @package App\Contract\User
 */
interface UserCreateInterface
{
    /**
     * @param UserCreateType $userCreateType
     * @return UserViewModel
     */
    public function create(UserCreateType $userCreateType) : UserViewModel;
}
