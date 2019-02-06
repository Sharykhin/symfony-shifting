<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Contract\Service\Response\ResponseInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PingController
 * @package App\Controller\API
 */
class PingController extends AbstractController
{
    /**
     * @Route("/ping", name="get_ping", methods={"GET"})
     *
     * @param ResponseInterface $response
     * @return Response
     */
    public function ping(
        ResponseInterface $response
    ): Response
    {
        return $response->success(['message' => 'pong']);
    }
}
