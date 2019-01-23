<?php

namespace App\Factory\ValueObject;

use App\Contract\Factory\ValueObject\ValidatorBagFactoryInterface;
use App\ValueObject\ValidatorBag;

/**
 * Class ValidatorBagFactory
 * @package App\Factory\ValueObject
 */
class ValidatorBagFactory implements ValidatorBagFactoryInterface
{
    /**
     * @param array $errors
     * @return ValidatorBag
     */
    public function create(array $errors = []) : ValidatorBag
    {
        return new ValidatorBag($errors);
    }
}
