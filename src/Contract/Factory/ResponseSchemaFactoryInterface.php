<?php

namespace App\Contract\Factory;

use App\ValueObject\ResponseSchema;

/**
 * Interface ResponseSchemaFactoryInterface
 * @package App\Contract\Factory
 */
interface ResponseSchemaFactoryInterface
{
    /**
     * @return ResponseSchema
     */
    public function create() : ResponseSchema;
}
