<?php

namespace App\Tests\Unit\Service\Response;

use App\Contract\Factory\ResponseSchemaFactoryInterface;
use App\Contract\Service\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Response\JsonResponseService;
use App\ValueObject\ResponseSchema;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonResponseServiceTest
 * @package App\Tests\Unit\Service\Response
 */
class JsonResponseServiceTest extends TestCase
{
    public function testSuccess()
    {
        $data = ['foo' => 'bar'];
        $response = '{"foo": "bar"}';

        $mockResponseSchemaFactory = $this->createMock(ResponseSchemaFactoryInterface::class);
        $mockSerializer = $this->createMock(SerializerInterface::class);
        $mockResponseSchema = $this->createMock(ResponseSchema::class);

        $mockResponseSchemaFactory
            ->expects($this->once())
            ->method('create')
            ->with()
            ->willReturn($mockResponseSchema);

        $mockResponseSchema
            ->expects($this->once())
            ->method('toArray')
            ->with()
            ->willReturn($data);

        $mockSerializer
            ->expects($this->once())
            ->method('serialize')
            ->with($data, ['groups' => ['public']])
            ->willReturn($response);

        $service = new JsonResponseService($mockResponseSchemaFactory, $mockSerializer);

        $actual = $service->success($data);
        $this->assertEquals(Response::HTTP_OK, $actual->getStatusCode());
        $this->assertEquals('application/json', $actual->headers->get('Content-Type'));
    }

    public function testCreated()
    {
        $data = ['foo' => 'bar'];
        $response = '{"foo": "bar"}';

        $mockResponseSchemaFactory = $this->createMock(ResponseSchemaFactoryInterface::class);
        $mockSerializer = $this->createMock(SerializerInterface::class);
        $mockResponseSchema = $this->createMock(ResponseSchema::class);

        $mockResponseSchemaFactory
            ->expects($this->once())
            ->method('create')
            ->with()
            ->willReturn($mockResponseSchema);

        $mockResponseSchema
            ->expects($this->once())
            ->method('toArray')
            ->with()
            ->willReturn($data);

        $mockSerializer
            ->expects($this->once())
            ->method('serialize')
            ->with($data, ['groups' => ['public']])
            ->willReturn($response);

        $service = new JsonResponseService($mockResponseSchemaFactory, $mockSerializer);

        $actual = $service->created($data);
        $this->assertEquals(Response::HTTP_CREATED, $actual->getStatusCode());
        $this->assertEquals('application/json', $actual->headers->get('Content-Type'));
    }
}
