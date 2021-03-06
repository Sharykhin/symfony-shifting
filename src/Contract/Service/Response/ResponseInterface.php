<?php

namespace App\Contract\Service\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Interface ResponseInterface
 * @package App\Contract\Response
 */
interface ResponseInterface
{
    /**
     * @param $data
     * @param array|null $warnings
     * @param array|null $meta
     * @param array $groups
     * @return Response
     */
    public function success($data, array $warnings = null, array $meta = null, array $groups = []): Response;

    /**
     * @param $data
     * @param array|null $warnings
     * @param array|null $meta
     * @param array $groups
     * @return Response
     */
    public function created($data, array $warnings = null, array $meta = null, array $groups = []): Response;

    /**
     * @param string $error
     * @param array|null $warnings
     * @param array|null $meta
     * @return Response
     */
    public function notFound(string $error, array $warnings = null, array $meta = null): Response;

    /**
     * @param string $error
     * @param array|null $warnings
     * @param array|null $meta
     * @return Response
     */
    public function forbidden(string $error, array $warnings = null, array $meta = null): Response;

    /**
     * @param $errors
     * @param array|null $warnings
     * @param array|null $meta
     * @return Response
     */
    public function badRequest($errors, array $warnings = null, array $meta = null): Response;

    /**
     * @param $errors
     * @param int $code
     * @return Response
     */
    public function error($errors, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): Response;
}
