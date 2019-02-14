<?php

namespace App\Contract\Factory;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * Interface SerializerFactoryInterface
 * @package App\Contract\Factory
 */
interface SerializerFactoryInterface
{
    /**
     * @param array $encoders
     * @param array $normalizers
     * @return SerializerInterface
     */
    public function create(array $encoders = [], array $normalizers = []): SerializerInterface;
}
