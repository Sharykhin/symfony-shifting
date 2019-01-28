<?php

namespace App\Service\User;

use App\Contract\Factory\ViewModel\UserViewModelFactoryInterface;
use App\Contract\Service\Serializer\SerializerInterface;
use App\Contract\Factory\Entity\ReportFactoryInterface;
use App\Contract\Factory\Entity\UserFactoryInterface;
use App\Contract\Service\User\UserRetrieverInterface;
use App\Contract\Service\User\UserCreateInterface;
use App\Request\Type\User\UserCreateType;
use Doctrine\ORM\EntityManagerInterface;
use App\ViewModel\UserViewModel;
use App\Entity\Report;
use DateTimeImmutable;
use App\Entity\User;

/**
 * Class UserManagerService
 * @package App\Service\User
 */
class UserManagerService implements UserRetrieverInterface, UserCreateInterface
{
    /** @var EntityManagerInterface $em */
    protected $em;

    /** @var UserFactoryInterface $userFactory */
    protected $userFactory;

    /** @var ReportFactoryInterface $reportFactory */
    protected $reportFactory;

    /** @var UserViewModelFactoryInterface $userViewModelFactory */
    protected $userViewModelFactory;

    /** @var SerializerInterface $serializer */
    protected $serializer;

    /**
     * UserManagerService constructor.
     * @param EntityManagerInterface $em
     * @param UserFactoryInterface $userFactory
     * @param ReportFactoryInterface $reportFactory
     * @param UserViewModelFactoryInterface $userViewModelFactory
     * @param SerializerInterface $serializer
     */
    public function __construct(
        EntityManagerInterface $em,
        UserFactoryInterface $userFactory,
        ReportFactoryInterface $reportFactory,
        UserViewModelFactoryInterface $userViewModelFactory,
        SerializerInterface $serializer
    )
    {
        $this->em = $em;
        $this->userFactory = $userFactory;
        $this->reportFactory = $reportFactory;
        $this->userViewModelFactory = $userViewModelFactory;
        $this->serializer = $serializer;
    }

    /**
     * @param int $userId
     * @return UserViewModel|null
     */
    public function findById(int $userId): ?UserViewModel
    {
        /** @var User|null $user */
        $user = $this->em->getRepository(User::class)->find($userId);

        if (is_null($user)) {
            return null;
        }

        return $this->userViewModelFactory->create(
            $this->serializer->normalize($user, ['id', 'email', 'firstName', 'lastName', 'activated'])
        );
    }

    /**
     * @param string $email
     * @return UserViewModel|null
     */
    public function findByEmail(string $email): ?UserViewModel
    {
        /** @var User|null $user */
        $user = $this->em->getRepository(User::class)->findOneByEmail($email);

        if (is_null($user)) {
            return null;
        }

        return $this->userViewModelFactory->create(
            $this->serializer->normalize($user, ['id', 'email', 'firstName', 'lastName', 'activated'])
        );
    }

    /**
     * @param UserCreateType $type
     * @return UserViewModel
     */
    public function create(UserCreateType $type) : UserViewModel
    {
        /** @var User $user */
        $user = $this->userFactory->create();
        $user->setEmail($type->email);
        $user->setFirstName($type->firstName);
        $user->setLastName($type->lastName);
        $user->setActivated($type->activated);

        $this->em->persist($user);
        /** @var Report $report */
        $report = $this->reportFactory->create();
        $report->setUser($user);
        $report->setAmount(0.00);
        $report->setDate(new DateTimeImmutable('now'));
        $this->em->persist($report);

        $this->em->flush();

        return $this->userViewModelFactory->create(
            $this->serializer->normalize($user, ['id', 'email', 'firstName', 'lastName', 'activated'])
        );
    }
}
