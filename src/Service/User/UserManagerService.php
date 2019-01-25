<?php

namespace App\Service\User;

use App\Contract\Factory\ViewModel\UserViewModelFactoryInterface;
use App\Contract\Factory\Entity\ReportFactoryInterface;
use App\Contract\Factory\Entity\UserFactoryInterface;
use App\Contract\Service\User\UserRetrieverInterface;
use App\Contract\Service\User\UserCreateInterface;
use App\Request\Type\User\UserCreateType;
use Doctrine\ORM\EntityManagerInterface;
use App\ViewModel\UserViewModel;
use App\Entity\Report;
use App\Entity\User;
use DateTime;

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

    /**
     * UserManagerService constructor.
     * @param EntityManagerInterface $em
     * @param UserFactoryInterface $userFactory
     * @param ReportFactoryInterface $reportFactory
     * @param UserViewModelFactoryInterface $userViewModelFactory
     */
    public function __construct(
        EntityManagerInterface $em,
        UserFactoryInterface $userFactory,
        ReportFactoryInterface $reportFactory,
        UserViewModelFactoryInterface $userViewModelFactory
    )
    {
        $this->em = $em;
        $this->userFactory = $userFactory;
        $this->reportFactory = $reportFactory;
        $this->userViewModelFactory = $userViewModelFactory;
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

        /** @var UserViewModel $userViewModel */
        $userViewModel = $this->userViewModelFactory->create();
        $userViewModel->setId($user->getId());
        $userViewModel->setFullName(trim($user->getFirstName() . ' ' . $user->getLastName()));
        $userViewModel->setEmail($user->getEmail());
        $userViewModel->setActivated($user->getActivated());

        return $userViewModel;
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

        /** @var UserViewModel $userViewModel */
        $userViewModel = $this->userViewModelFactory->create();
        $userViewModel->setId($user->getId());
        $userViewModel->setFullName(trim($user->getFirstName() . ' ' . $user->getLastName()));
        $userViewModel->setEmail($user->getEmail());
        $userViewModel->setActivated($user->getActivated());

        return $userViewModel;
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
        $report->setDate(new DateTime('now'));
        $this->em->persist($report);

        $this->em->flush();

        /** @var UserViewModel $userViewModel */
        $userViewModel = $this->userViewModelFactory->create();
        $userViewModel->setId($user->getId());
        $userViewModel->setFullName(trim($user->getFirstName() . ' ' . $user->getLastName()));
        $userViewModel->setEmail($user->getEmail());
        $userViewModel->setActivated($user->getActivated());

        return $userViewModel;
    }
}
