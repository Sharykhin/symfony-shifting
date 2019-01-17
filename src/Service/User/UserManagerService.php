<?php

namespace App\Service\User;

use App\Contract\Factory\ReportFactoryInterface;
use App\Contract\Factory\UserFactoryInterface;
use App\Contract\User\UserRetrieverInterface;
use App\Contract\User\UserCreateInterface;
use App\Entity\Report;
use DateTime;
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

    /** @var UserFactoryInterface $userFactory */
    protected $userFactory;

    /** @var ReportFactoryInterface $reportFactory */
    protected $reportFactory;

    /**
     * UserManagerService constructor.
     * @param EntityManagerInterface $em
     * @param UserFactoryInterface $userFactory
     * @param ReportFactoryInterface $reportFactory
     */
    public function __construct(
        EntityManagerInterface $em,
        UserFactoryInterface $userFactory,
        ReportFactoryInterface $reportFactory
    )
    {
        $this->em = $em;
        $this->userFactory = $userFactory;
        $this->reportFactory = $reportFactory;
    }

    /**
     * @param int $userId
     * @return User|null
     */
    public function findById(int $userId): ?User
    {
        /** @var User|null $user */
        $user = $this->em->getRepository(User::class)->find($userId);

        return $user;
    }

    /**
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function create(array $data) : User
    {
        /** @var User $user */
        $user = $this->userFactory->create();
        $user->setEmail($data['email']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name'] ?? null);

        $this->em->persist($user);
        /** @var Report $report */
        $report = $this->reportFactory->create();
        $report->setUser($user);
        $report->setAmount(0.00);
        $report->setDate(new DateTime('now'));
        $this->em->persist($report);

        $this->em->flush();

        return $user;
    }
}
