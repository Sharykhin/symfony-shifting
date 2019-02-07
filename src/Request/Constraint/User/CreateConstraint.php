<?php

namespace App\Request\Constraint\User;

use Symfony\Component\Validator\Constraints as Assert;
use App\Request\Constraint\AbstractConstrain;

/**
 * Class CreateConstraint
 * @package App\Request\Constraint\User
 */
class CreateConstraint extends AbstractConstrain
{
    /**
     * @return Assert\Collection
     */
    public function getConstrain(): Assert\Collection
    {
        return new Assert\Collection([
            'groups' => ['creating', 'updating', 'registering', 'authenticating'],
            'fields' => [
                'email' => [
                    new Assert\NotBlank(['groups' => ['creating', 'registering', 'authenticating']]),
                    new Assert\Email(['groups' => ['creating', 'registering', 'authenticating']]),
                ],
                'first_name' => [
                    new Assert\NotBlank(['groups' => ['creating', 'registering']]),
                    new Assert\Type(['groups' => ['creating', 'registering'], 'type' => 'string']),
                ],
                'last_name' => [
                    new Assert\Type(['groups' => ['creating', 'registering'], 'type' => 'string']),
                ],
                'password' => [
                    new Assert\NotBlank(['groups' => ['creating', 'registering', 'authenticating']]),
                    new Assert\Type(['groups' => ['creating', 'registering', 'authenticating'], 'type' => 'string']),
                    new Assert\Length(['groups' => ['creating', 'registering', 'authenticating'], 'min' => 8, 'max' => 4096]), //CVE-2013-5750 https://symfony.com/blog/cve-2013-5750-security-issue-in-fosuserbundle-login-form
                ],
                'activated' => [
                    new Assert\Type(['groups' => ['updating'], 'type' => 'bool'])
                ],
                'roles' => [
                    new Assert\Type(['groups' => ['updating', 'creating'], 'type' => 'array'])
                ]
            ],
            'allowMissingFields' => true,
            'allowExtraFields' => false
        ]);
    }
}
