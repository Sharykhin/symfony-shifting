<?php

namespace App\Contract\Service\Serializer;

/**
 * Interface NormalizerInterface
 * @package App\Contract\Service\Serializer
 */
interface NormalizerInterface
{
    /**
     * @param $object
     * @param array $attributes
     * @return array
     */
    public function normalize($object, array $attributes = []): array;
}
