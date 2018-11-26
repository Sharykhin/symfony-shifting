<?php

namespace App\Contract\User;

use App\Entity\User;

/**
 * Interface UserRetrieverInterface
 * @package App\Contract\User
 */
interface UserRetrieverInterface
{
    /**
     * @param int $userId
     * @return User|null
     */
    public function findById(int $userId) : ?User;
}
