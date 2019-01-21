<?php

namespace App\Factory\ViewModel;

use App\Contract\Factory\ViewModel\UserViewModelFactoryInterface;
use App\ViewModel\UserViewModel;

/**
 * Class UserViewModelFactory
 * @package App\Factory\ViewModel
 */
class UserViewModelFactory implements UserViewModelFactoryInterface
{
    /**
     * @return UserViewModel
     */
    public function create() : UserViewModel
    {
        return new UserViewModel();
    }
}
