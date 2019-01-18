<?php

namespace App\Tests\Service;

use App\Contract\Factory\SerializerFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\Serializer\JsonSerializerService;
use Symfony\Component\Serializer\Serializer;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonSerializerServiceTest
 * @package App\Tests\Service
 */
class JsonSerializerServiceTest extends TestCase
{
    public function testSerialize()
    {
        $data = ['foo' => 'bar'];
        $context = ['groups' => ['public']];
        $response = '{"foo": "bar"}';

        $mockSerializerFactory = $this->createMock(SerializerFactoryInterface::class);
        $mockSerializer = $this->createMock(Serializer::class);

        $mockSerializerFactory
            ->expects($this->once())
            ->method('create')
            ->with(['json'])
            ->willReturn($mockSerializer);

        $mockSerializer
            ->expects($this->once())
            ->method('serialize')
            ->with($data, 'json', array_merge([
                'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS
            ], $context))
            ->willReturn($response);

        $service = new JsonSerializerService($mockSerializerFactory);
        $actual = $service->serialize($data, $context);

        $this->assertEquals($response, $actual);
    }
}