<?php

namespace App\Contract\Service\Auth;

use App\ViewModel\UserViewModel;

/**
 * Interface AuthInterface
 * @package App\Contract\Service\Auth
 */
interface AuthInterface
{
    /**
     * @param string $email
     * @param string $password
     * @return UserViewModel|null
     */
    public function authenticate(string $email, string $password): ?UserViewModel;
}
