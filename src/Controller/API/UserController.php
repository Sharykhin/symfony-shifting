<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Contract\User\UserRetrieverInterface;
use App\Contract\Response\ResponseInterface;
use App\Contract\User\UserCreateInterface;

/**
 * Class UserController
 * @package App\Controller\API
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users/{userId}", name="get_user", methods={"GET"}, requirements={"userId"="\d+"})
     *
     * @param UserRetrieverInterface $userRetriever
     * @param ResponseInterface $response
     * @param int $userId
     * @return Response
     * @internal param SerializerInterface $serializer
     */
    public function show(
        UserRetrieverInterface $userRetriever,
        ResponseInterface $response,
        int $userId
    )
    {
        $user = $userRetriever->findById($userId);

        return $response->success($user);
    }

    /**
     * @Route("/users", name="post_user", methods={"POST"})
     *
     * @param Request $request
     * @param UserCreateInterface $userCreate
     * @return JsonResponse
     */
    public function store(
        Request $request,
        UserCreateInterface $userCreate
    ) : JsonResponse
    {
        $user = $userCreate->create($request->request->all());
        return $this->json($user, JsonResponse::HTTP_CREATED);
    }
}
