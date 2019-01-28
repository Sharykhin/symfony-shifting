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
     * @param array $context
     * @return mixed
     */
    public function normalize($object, array $context = array());
}
