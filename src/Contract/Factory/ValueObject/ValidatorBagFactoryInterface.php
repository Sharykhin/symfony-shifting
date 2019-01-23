<?php

namespace App\Contract\Factory\ValueObject;

use App\ValueObject\ValidatorBag;

/**
 * Interface ValidatorBagFactoryInterface
 * @package App\Contract\Factory\ValueObject
 */
interface ValidatorBagFactoryInterface
{
    /**
     * @param array $errors
     * @return ValidatorBag
     */
    public function create(array $errors) : ValidatorBag;
}
