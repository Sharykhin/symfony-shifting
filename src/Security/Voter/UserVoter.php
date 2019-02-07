<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use App\ViewModel\UserViewModel;
use App\Entity\User;

/**
 * Class UserVoter
 * @package App\Security\Voter
 */
class UserVoter extends Voter
{

    const CREATE_INVOICE = 'create-invoice';

    const VIEW_INVOICES = 'view-invoices';

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports($attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::CREATE_INVOICE, self::VIEW_INVOICES])) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof UserViewModel) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        /** @var UserViewModel $post */
        $userView = $subject;

        switch ($attribute) {
            case self::CREATE_INVOICE:
                return $this->canCreateInvoice($userView, $user);
            case self::VIEW_INVOICES:
                return $this->canViewInvoices($userView, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param UserViewModel $userView
     * @param User $user
     * @return bool
     */
    private function canCreateInvoice(UserViewModel $userView, User $user): bool
    {
        return $userView->getId() === $user->getId() || in_array('ROLE_ADMIN', $user->getRoles());
    }

    /**
     * @param UserViewModel $userView
     * @param User $user
     * @return bool
     */
    private function canViewInvoices(UserViewModel $userView, User $user): bool
    {
        if ($this->canCreateInvoice($userView, $user)) {
            return true;
        }

        return $userView->getId() === $user->getId() || in_array('ROLE_ADMIN', $user->getRoles());
    }
}
