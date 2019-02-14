<?php

namespace App\Contract\Service\Validate;

use App\ValueObject\ValidatorBag;

/**
 * Interface ValidateInterface
 * @package App\Contract\Service\Validate
 */
interface ValidateInterface
{
    /**
     * @param $values
     * @param $constraintClass
     * @param array|null $groups
     * @return ValidatorBag
     */
    public function validate($values, $constraintClass, array $groups = null): ValidatorBag;
}
