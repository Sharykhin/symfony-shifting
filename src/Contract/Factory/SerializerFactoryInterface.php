<?php

namespace App\Contract\Factory;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Interface SerializerFactoryInterface
 * @package App\Contract\Factory
 */
interface SerializerFactoryInterface
{
    /**
     * @param array $encoders
     * @param ObjectNormalizer|null $normalizer
     * @return SerializerInterface
     */
    public function create(array $encoders = [], ObjectNormalizer $normalizer = null) : SerializerInterface;
}
