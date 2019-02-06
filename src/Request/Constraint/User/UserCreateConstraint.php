<?php

namespace App\Request\Constraint\User;

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
                    new Assert\NotBlank(['groups' => ['creating']]),
                    new Assert\Email(['groups' => ['creating', 'updating']]),
                ],
                'first_name' => [
                    new Assert\NotBlank(['groups' => ['creating']]),
                    new Assert\Type(['groups' => ['creating', 'updating'], 'type' => 'string']),
                ],
                'last_name' => [
                    new Assert\Type(['groups' => ['creating', 'updating'], 'type' => 'string']),
                ],
                'password' => [
                    new Assert\NotBlank(['groups' => ['creating']]),
                    new Assert\Type(['groups' => ['creating'], 'type' => 'string']),
                    new Assert\Length(['groups' => ['creating'], 'min' => 8, 'max' => 4096]), //CVE-2013-5750 https://symfony.com/blog/cve-2013-5750-security-issue-in-fosuserbundle-login-form
                ],
                'activated' => [
                    new Assert\Type(['groups' => ['updating'], 'type' => 'bool'])
                ]
            ],
            'allowMissingFields' => false,
            'allowExtraFields' => false
        ]);
    }
}
