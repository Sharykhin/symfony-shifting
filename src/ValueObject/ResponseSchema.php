<?php

namespace App\ValueObject;

/**
 * Class ResponseSchema
 * @package App\ValueObject
 */
class ResponseSchema
{
    public $result;

    public $warnings;

    public $errors;

    public $meta;

    /**
     * @return array
     */
    public function toArray() : array
    {
        return [
            'result' => $this->result,
            'warnings' => $this->warnings,
            'errors' => $this->errors,
            'meta' => $this->meta
        ];
    }
}
