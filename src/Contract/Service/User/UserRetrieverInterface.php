<?php

namespace App\Contract\Service\User;

use App\ViewModel\UserViewModel;

/**
 * Interface UserRetrieverInterface
 * @package App\Contract\User
 */
interface UserRetrieverInterface
{
    /**
     * @param int $userId
     * @return UserViewModel|null
     */
    public function findById(int $userId): ?UserViewModel;

    /**
     * @param string $email
     * @return bool
     */
    public function existsEmail(string $email): bool;
}
