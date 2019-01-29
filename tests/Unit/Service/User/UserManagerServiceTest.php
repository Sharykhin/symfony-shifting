<?php

namespace App\Tests\Unit\Service\User;

use App\Contract\Factory\ViewModel\UserViewModelFactoryInterface;
use App\Contract\Factory\Entity\ReportFactoryInterface;
use App\Contract\Factory\Entity\UserFactoryInterface;
use App\Service\User\UserManagerService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\ViewModel\UserViewModel;
use PHPUnit\Framework\TestCase;
use App\Entity\User;

/**
 * Class UserManagerServiceTest
 * @package App\Tests\Unit\Service\User
 */
class UserManagerServiceTest extends TestCase
{
    /**
     * @test findById
     */
    public function findByIdSuccess()
    {
        $expectedUserId = 1;
        $expectedRepositoryResult = (object) [
            'id' => 1,
            'email' => 'test@mail.com',
            'firstName' => 'Sergey',
            'lastName' => 'Sharykhin',
            'activated' => null,
            'totalNumber' => 2,
            'totalAmount' => 100.50
        ];
        $expectedViewModelData = [
            'id' => 1,
            'email' => 'test@mail.com',
            'firstName' => 'Sergey',
            'lastName' => 'Sharykhin',
            'activated' => null,
            'totalNumber' => 2,
            'totalAmount' => 100.50
        ];

        $mockEm = $this->createMock(EntityManagerInterface::class);
        $mockUserFactory = $this->createMock(UserFactoryInterface::class);
        $mockReportFactory = $this->createMock(ReportFactoryInterface::class);
        $mockUserViewModelFactory = $this->createMock(UserViewModelFactoryInterface::class);
        $mockUserRepository = $this->createMock(UserRepository::class);
        $mockUserViewModel = $this->createMock(UserViewModel::class);

        $mockEm
            ->expects($this->once())
            ->method('getRepository')
            ->with(User::class)
            ->willReturn($mockUserRepository);

        $mockUserRepository
            ->expects($this->once())
            ->method('findOneWithTotalInvoices')
            ->with($expectedUserId)
            ->willReturn($expectedRepositoryResult);

        $mockUserViewModelFactory
            ->expects($this->once())
            ->method('create')
            ->with($expectedViewModelData)
            ->willReturn($mockUserViewModel);

        $service = new UserManagerService(
            $mockEm,
            $mockUserFactory,
            $mockReportFactory,
            $mockUserViewModelFactory
        );

        $actual = $service->findById($expectedUserId);

        $this->assertInstanceOf(UserViewModel::class, $actual);
    }

    /**
     * @test findById
     */
    public function findByIdFail()
    {
        $expectedUserId = 1;
        $expectedRepositoryResult = null;

        $mockEm = $this->createMock(EntityManagerInterface::class);
        $mockUserFactory = $this->createMock(UserFactoryInterface::class);
        $mockReportFactory = $this->createMock(ReportFactoryInterface::class);
        $mockUserViewModelFactory = $this->createMock(UserViewModelFactoryInterface::class);
        $mockUserRepository = $this->createMock(UserRepository::class);

        $mockEm
            ->expects($this->once())
            ->method('getRepository')
            ->with(User::class)
            ->willReturn($mockUserRepository);

        $mockUserRepository
            ->expects($this->once())
            ->method('findOneWithTotalInvoices')
            ->with($expectedUserId)
            ->willReturn($expectedRepositoryResult);

        $mockUserViewModelFactory
            ->expects($this->never())
            ->method('create');

        $service = new UserManagerService(
            $mockEm,
            $mockUserFactory,
            $mockReportFactory,
            $mockUserViewModelFactory
        );

        $actual = $service->findById($expectedUserId);

        $this->assertNull($actual);
    }
}