<?php

namespace App\Request\Constraint\User;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Request\Constraint\AbstractConstrain;

/**
 * Class UserCreateConstraint
 * @package App\Request\Constraint\User
 */
class UserCreateConstraint extends AbstractConstrain
{
    /**
     * @return Assert\Collection
     */
    public function getConstrain(): Assert\Collection
    {
        return new Assert\Collection([
            'groups' => ['creating', 'updating'],
            'fields' => [
                'email' => [
                    new Assert\Email(['groups' => ['creating']]),
                ],
                'first_name' => [
                    new Assert\NotBlank(['groups' => ['creating']])
                ],
                'last_name' => [
                    new Assert\NotBlank(['groups' => ['creating']])
                ],
            ],
            'allowMissingFields' => false,
            'allowExtraFields' => false
        ]);
    }
}