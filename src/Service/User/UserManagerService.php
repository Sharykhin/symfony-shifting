<?php

namespace App\Service\User;

use App\Contract\User\UserRetrieverInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

/**
 * Class UserManagerService
 * @package App\Service\User
 */
class UserManagerService implements UserRetrieverInterface
{
    /** @var EntityManagerInterface $em */
    protected $em;

    /** @var \Doctrine\Common\Persistence\ObjectRepository $userRepository */
    protected $userRepository;

    /**
     * UserManagerService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
        $this->userRepository = $em->getRepository(User::class);
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function findById(int $userId): ?User
    {
        return $this->userRepository->find($userId);
    }
}
