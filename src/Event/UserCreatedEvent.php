<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;
use App\ViewModel\UserViewModel;

/**
 * Class UserCreatedEvent
 * @package App\Event
 */
class UserCreatedEvent extends Event
{
    const NAME = 'user.created';

    /** @var UserViewModel $user */
    protected $user;

    /**
     * UserCreatedEvent constructor.
     * @param UserViewModel $user
     */
    public function __construct(UserViewModel $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserViewModel
     */
    public function getUser(): UserViewModel
    {
        return $this->user;
    }
}
