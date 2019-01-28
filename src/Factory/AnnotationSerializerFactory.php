<?php

namespace App\Factory;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use App\Contract\Factory\SerializerFactoryInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Serializer;
use InvalidArgumentException;

/**
 * Class SerializerFactory
 * @package App\Factory
 */
class AnnotationSerializerFactory implements SerializerFactoryInterface
{
    const JSON_ENCODER = 'json';

    /**
     * @param array $encoders
     * @param array $normalizers
     * @return SerializerInterface
     */
    public function create(array $encoders = [], array $normalizers = []) : SerializerInterface
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $serializeEncoders = [];

        /** @var string $encoder */
        foreach ($encoders as $encoder) {
            switch ($encoder) {
                case static::JSON_ENCODER:
                    $serializeEncoders[] = new JsonEncoder();
                    break;
                default:
                    throw new InvalidArgumentException('The provided encoder' . $encoder . ' is not supported');
            }
        }

        if (empty($normalizers)) {
            $normalizers = [
                new DateTimeNormalizer(),
                new ObjectNormalizer($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter())
            ];
        }

        $serializer = new Serializer($normalizers, $serializeEncoders);

        return $serializer;
    }
}
