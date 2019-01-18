<?php

namespace App\Service\Serializer;

use App\Contract\Factory\SerializerFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Contract\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * Class JsonSerializerService
 * @package App\Service\Serializer
 */
class JsonSerializerService implements SerializerInterface
{
    /** @var Serializer $serializer */
    protected $serializer;

    /**
     * SerializerService constructor.
     * @param SerializerFactoryInterface $serializerFactory
     */
    public function __construct(
        SerializerFactoryInterface $serializerFactory
    )
    {
        $this->serializer = $serializerFactory->create(['json']);
    }

    /**
     * @param $data
     * @param array $context
     * @return string
     */
    public function serialize($data, array $context = [])
    {
        return $this->serializer->serialize($data, 'json', array_merge([
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS
        ], $context));
    }
}


