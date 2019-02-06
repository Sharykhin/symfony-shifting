<?php

namespace App\Controller\API;

use App\Contract\Service\Response\ResponseInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AuthController
 * @package App\Controller\API
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/register", name="post_register", methods={"POST"})
     *
     * @param Request $request
     * @param ResponseInterface $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(
        Request $request,
        ResponseInterface $response
    ): Response
    {
        return $response->success(['user' => ['name' => 'foo'], 'token' => 'token']);
    }
}