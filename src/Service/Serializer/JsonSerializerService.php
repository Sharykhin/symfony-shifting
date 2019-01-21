<?php

namespace App\Service\Serializer;

use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;
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
     * JsonSerializerService constructor.
     * @param SymfonySerializerInterface $serializer
     */
    public function __construct(
        SymfonySerializerInterface $serializer
    )
    {
        $this->serializer = $serializer;
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


