<?php

namespace App\Contract\Service\User;

use App\ViewModel\UserViewModel;

/**
 * Interface UserCreateInterface
 * @package App\Contract\User
 */
interface UserCreateInterface
{
    /**
     * @param array $data
     * @return UserViewModel
     */
    public function create(array $data) : UserViewModel;
}
