<?php

namespace App\Contract\Response;

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
    public function success($data, array $warnings = null, array $meta = null, array $groups = []) : Response;
}
