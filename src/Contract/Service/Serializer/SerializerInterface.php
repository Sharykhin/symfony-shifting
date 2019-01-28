<?php

namespace App\Contract\Service\Serializer;

/**
 * Interface SerializerInterface
 * @package App\Contract\Serializer
 */
interface SerializerInterface extends NormalizerInterface
{
    /**
     * @param $data
     * @param array $context
     * @return mixed
     */
    public function serialize($data, array $context = []);
}
