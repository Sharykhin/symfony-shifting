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

    public function notFound(string $error, array $warnings = null, array $meta = null): Response
    {
        /** @var ResponseSchema $schema */
        $schema = $this->responseSchemaFactory->create();
        $schema->warnings = $warnings;
        $schema->meta = $meta;
        $schema->errors = [
            'message' => $error
        ];

        return $this->sendResponse($schema, [], Response::HTTP_NOT_FOUND);
    }

    public function forbidden(string $error, array $warnings = null, array $meta = null): Response
    {
        /** @var ResponseSchema $schema */
        $schema = $this->responseSchemaFactory->create();
        $schema->warnings = $warnings;
        $schema->meta = $meta;
        $schema->errors = [
            'message' => $error
        ];

        return $this->sendResponse($schema, [], Response::HTTP_FORBIDDEN);
    }

    /**
     * @param $errors
     * @param array|null $warnings
     * @param array|null $meta
     * @return Response
     */
    public function badRequest($errors, array $warnings = null, array $meta = null): Response
    {
        if (is_string($errors)) {
            $errors = ['message' => $errors];
        }
        /** @var ResponseSchema $schema */
        $schema = $this->responseSchemaFactory->create();
        $schema->warnings = $warnings;
        $schema->meta = $meta;
        $schema->errors = $errors;

        return $this->sendResponse($schema, [], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param $errors
     * @param int $code
     * @return Response
     */
    public function error($errors, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): Response
    {
        if (is_string($errors)) {
            $errors = ['message' => $errors];
        }

        /** @var ResponseSchema $schema */
        $schema = $this->responseSchemaFactory->create();
        $schema->errors = $errors;

        return $this->sendResponse($schema, [], $code);
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
