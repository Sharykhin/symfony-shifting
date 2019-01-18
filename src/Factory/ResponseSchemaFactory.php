<?php

namespace App\Factory;

use App\Contract\Factory\ResponseSchemaFactoryInterface;
use App\ValueObject\ResponseSchema;

/**
 * Class ResponseSchemaFactory
 * @package App\Factory
 */
class ResponseSchemaFactory implements ResponseSchemaFactoryInterface
{
    /**
     * @return ResponseSchema
     */
    public function create() : ResponseSchema
    {
        return new ResponseSchema();
    }
}
