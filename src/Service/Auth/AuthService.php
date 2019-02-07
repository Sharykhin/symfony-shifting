<?php

namespace App\Service\Auth;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use App\Contract\Factory\ViewModel\UserViewModelFactoryInterface;
use App\Contract\Service\Auth\AuthInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\ViewModel\UserViewModel;
use App\Entity\User;

/**
 * Class AuthService
 * @package App\Service\Auth
 */
class AuthService implements AuthInterface
{
    /** @var EntityManagerInterface $em */
    protected $em;

    /** @var EncoderFactoryInterface $encoderFactory */
    protected $encoderFactory;

    /** @var UserViewModelFactoryInterface $userViewModelFactory */
    protected $userViewModelFactory;

    /**
     * AuthService constructor.
     * @param EntityManagerInterface $em
     * @param EncoderFactoryInterface $encoderFactory
     * @param UserViewModelFactoryInterface $userViewModelFactory
     */
    public function __construct(
        EntityManagerInterface $em,
        EncoderFactoryInterface $encoderFactory,
        UserViewModelFactoryInterface $userViewModelFactory
    )
    {
        $this->em = $em;
        $this->encoderFactory = $encoderFactory;
        $this->userViewModelFactory = $userViewModelFactory;
    }

    /**
     * @param string $email
     * @param string $password
     * @return UserViewModel|null
     */
    public function authenticate(string $email, string $password): ?UserViewModel
    {
        /** @var User $user */
        $user = $this->em->getRepository(User::class)->findOneByEmail($email);
        if (is_null($user)) {
            return null;
        }

        if (is_null($user->getActivated())) {
            return null;
        }

        $encoder = $this->encoderFactory->getEncoder($user);
        $validPassword = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());

        if (!$validPassword) {
            return null;
        }

        $userInvoiceAggregated = $this->em->getRepository(User::class)->findOneWithTotalInvoices($user->getId());

        return $this->userViewModelFactory->create((array) $userInvoiceAggregated);
    }
}
