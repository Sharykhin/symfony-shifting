<?php

namespace App\Service\User;

use App\Contract\User\UserCreateInterface;
use App\Contract\User\UserRetrieverInterface;
use App\Factory\UserFactory;
use App\Request\User\UserCreateRequest;
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
     * @param UserCreateRequest $request
     * @return User
     */
    public function create(UserCreateRequest $request) : User
    {
        /** @var User $user */
        $user = $this->userFactory->create();
        $user->setEmail($request->email);
        $user->setFirstName($request->firstName);
        $user->setLastName($request->lastName);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
