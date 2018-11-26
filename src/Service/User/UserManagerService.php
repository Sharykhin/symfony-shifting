<?php

namespace App\Service\User;

use App\Contract\User\UserCreateInterface;
use App\Contract\User\UserRetrieverInterface;
use App\Factory\UserFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

/**
 * Class UserManagerService
 * @package App\Service\User
 */
class UserManagerService implements UserRetrieverInterface, UserCreateInterface
{
    /** @var EntityManagerInterface $em */
    protected $em;

    /** @var \Doctrine\Common\Persistence\ObjectRepository $userRepository */
    protected $userRepository;

    /** @var UserFactory $userFactory */
    protected $userFactory;

    /**
     * UserManagerService constructor.
     * @param EntityManagerInterface $em
     * @param UserFactory $userFactory
     */
    public function __construct(
        EntityManagerInterface $em,
        UserFactory $userFactory
    )
    {
        $this->em = $em;
        $this->userRepository = $em->getRepository(User::class);
        $this->userFactory = $userFactory;
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function findById(int $userId): ?User
    {
        return $this->userRepository->find($userId);
    }

    /**
     * @param array $data
     * @return User
     */
    public function create(array $data) : User
    {
        /** @var User $user */
        $user = $this->userFactory->create();
        $user->setEmail($data['email']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
