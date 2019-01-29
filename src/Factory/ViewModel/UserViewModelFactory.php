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
     * @param array $data
     * @return UserViewModel
     */
    public function create(array $data) : UserViewModel
    {
        $data['full_name'] = trim($data['firstName'] . ' ' . $data['lastName'] ?? '');

        return new UserViewModel($data);
    }
}
