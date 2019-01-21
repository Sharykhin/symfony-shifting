<?php

namespace App\Contract\User;

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
    public function findById(int $userId) : ?UserViewModel;
}
