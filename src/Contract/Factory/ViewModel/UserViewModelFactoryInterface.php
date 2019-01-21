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
     * @return UserViewModel
     */
    public function create() : UserViewModel;
}
