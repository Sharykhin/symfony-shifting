<?php

namespace App\Controller\API;

use App\Contract\User\UserCreateInterface;
use App\Contract\User\UserRetrieverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users/{userId}", name="get_user", methods={"GET"}, requirements={"userId"="\d+"})
     *
     * @param UserRetrieverInterface $userRetriever
     * @param int $userId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(
        UserRetrieverInterface $userRetriever,
        int $userId
    )
    {
        $user = $userRetriever->findById($userId);

        return $this->json($user);
    }

    /**
     * @Route("/users", name="post_user", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(
        Request $request,
        UserCreateInterface $userCreate
    )
    {
        var_dump($request->getContent());
        return $this->json([], JsonResponse::HTTP_CREATED);
    }
}
