<?php

namespace App\Service\Response;

use App\Contract\Factory\ResponseSchemaFactoryInterface;
use App\Contract\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Contract\Response\ResponseInterface;
use App\ValueObject\ResponseSchema;


/**
 * Class JsonResponseService
 * @package App\Service\Response
 */
class JsonResponseService implements ResponseInterface
{
    /** @var ResponseSchemaFactoryInterface $responseSchemaFactory */
    protected $responseSchemaFactory;

    /** @var SerializerInterface $serializer */
    protected $serializer;

    /**
     * JsonResponseService constructor.
     * @param ResponseSchemaFactoryInterface $responseSchemaFactory
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ResponseSchemaFactoryInterface $responseSchemaFactory,
        SerializerInterface $serializer
    )
    {
        $this->responseSchemaFactory = $responseSchemaFactory;
        $this->serializer = $serializer;
    }

    /**
     * @param $data
     * @param array|null $warnings
     * @param array|null $meta
     * @param array $groups
     * @return Response
     */
    public function success($data, array $warnings = null, array $meta = null, array $groups = ['public']) : Response
    {
        /** @var ResponseSchema $schema */
        $schema = $this->responseSchemaFactory->create();
        $schema->result = $data;
        $schema->warnings = $warnings;
        $schema->meta = $meta;

        $response = $schema->toArray();

        return new Response(
            $this->serializer->serialize($response, ['groups' => $groups]),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }
}
