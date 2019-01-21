<?php

namespace App\Service\Response;

use App\Contract\Factory\ResponseSchemaFactoryInterface;
use App\Contract\Service\Serializer\SerializerInterface;
use App\Contract\Service\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
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

        return $this->sendResponse($schema, $groups, Response::HTTP_OK);
    }

    /**
     * @param $data
     * @param array|null $warnings
     * @param array|null $meta
     * @param array $groups
     * @return Response
     */
    public function created($data, array $warnings = null, array $meta = null, array $groups = ['public']): Response
    {
        /** @var ResponseSchema $schema */
        $schema = $this->responseSchemaFactory->create();
        $schema->result = $data;
        $schema->warnings = $warnings;
        $schema->meta = $meta;

        return $this->sendResponse($schema, $groups, Response::HTTP_CREATED);
    }

    /**
     * @param ResponseSchema $schema
     * @param array $groups
     * @param int $statusCode
     * @return Response
     */
    protected function sendResponse(ResponseSchema $schema, array $groups, int $statusCode) : Response
    {
        $response = $schema->toArray();

        return new Response(
            $this->serializer->serialize($response, ['groups' => $groups]),
            $statusCode,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }
}
