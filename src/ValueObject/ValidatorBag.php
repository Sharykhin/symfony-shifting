<?php

namespace App\ValueObject;

/**
 * Class ValidatorBag
 * @package App\ValueObject
 */
class ValidatorBag
{
    /** @var array $errors */
    protected $errors = [];

    /**
     * ValidatorBag constructor.
     * @param array $errors
     */
    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return 0 === sizeof($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
