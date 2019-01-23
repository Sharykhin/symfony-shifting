<?php

namespace App\Controller\API;

use App\Contract\Service\Validate\ValidateInterface;
use App\Event\UserCreatedEvent;
use App\Request\Constraint\User\UserCreateConstraint;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Contract\Service\User\UserRetrieverInterface;
use App\Contract\Service\Response\ResponseInterface;
use App\Contract\Service\User\UserCreateInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     * @param TranslatorInterface $translator
     * @param int $userId
     * @return Response
     */
    public function show(
        UserRetrieverInterface $userRetriever,
        ResponseInterface $response,
        TranslatorInterface $translator,
        int $userId
    ) : Response
    {
        $user = $userRetriever->findById($userId);

        if (is_null($user)) {
            return $response->notFound($translator->trans('User with id %id% was not found', ['%id%' => $userId]));
        }

        return $response->success($user);
    }

    /**
     * @Route("/users", name="post_user", methods={"POST"})
     *
     * @param Request $request
     * @param UserCreateInterface $userCreate
     * @param UserRetrieverInterface $userRetriever
     * @param TranslatorInterface $translator
     * @param ValidateInterface $validate
     * @param ResponseInterface $response
     * @param EventDispatcherInterface $dispatcher
     * @return Response
     */
    public function store(
        Request $request,
        UserCreateInterface $userCreate,
        UserRetrieverInterface $userRetriever,
        TranslatorInterface $translator,
        ValidateInterface $validate,
        ResponseInterface $response,
        EventDispatcherInterface $dispatcher
    ) : Response
    {
        $validatorBag = $validate->validate(
            $request->request->all(),
            UserCreateConstraint::class,
            ['creating']
        );

        if (!$validatorBag->isValid()) {
            return $response->badRequest($validatorBag->getErrors());
        }

        $user = $userRetriever->findByEmail($request->get('email'));

        if (!is_null($user)) {
            return $response->badRequest(['email' => $translator->trans('User with such email already exists')]);
        }

        $user = $userCreate->create($request->request->all());

        $dispatcher->dispatch(UserCreatedEvent::NAME, new UserCreatedEvent($user));

        return $response->created($user);
    }
}
