<?php

namespace App\Contract\Factory\ViewModel;

use App\ViewModel\UserViewModel;

/**
 * Interface UserViewModelFactoryInterface
 * @package App\Contract\Factory\ViewModel
 */
interface UserViewModelFactoryInterface
{
    /**
     * @param array $data
     * @return UserViewModel
     */
    public function create(array $data): UserViewModel;
}
