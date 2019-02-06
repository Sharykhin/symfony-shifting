<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Contract\Service\User\UserRetrieverInterface;
use App\Request\Constraint\User\UserCreateConstraint;
use App\Contract\Service\Validate\ValidateInterface;
use App\Contract\Service\Response\ResponseInterface;
use App\Contract\Service\User\UserCreateInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Contract\Service\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Request\Type\User\UserCreateType;
use App\ValueObject\ValidatorBag;
use App\Event\UserCreatedEvent;

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
     * @param ValidateInterface $validate
     * @param ResponseInterface $response
     * @param UserCreateInterface $userCreate
     * @param UserRetrieverInterface $userRetriever
     * @param TranslatorInterface $translator
     * @param EventDispatcherInterface $dispatcher
     * @param TokenInterface $tokenManager
     * @return Response
     */
    public function register(
        Request $request,
        ValidateInterface $validate,
        ResponseInterface $response,
        UserCreateInterface $userCreate,
        UserRetrieverInterface $userRetriever,
        TranslatorInterface $translator,
        EventDispatcherInterface $dispatcher,
        TokenInterface $tokenManager
    ): Response
    {
        $userCreateType = new UserCreateType($request->request->all());

        /** @var ValidatorBag $validatorBag */
        $validatorBag = $validate->validate(
            $userCreateType->toArray(),
            UserCreateConstraint::class,
            ['registering']
        );

        if (!$validatorBag->isValid()) {
            return $response->badRequest($validatorBag->getErrors());
        }

        if ($userRetriever->existsEmail($request->get('email'))) {
            return $response->badRequest(['email' => $translator->trans('User with such email already exists')]);
        }

        $user = $userCreate->create($userCreateType);
        $token = $tokenManager->encode(['id' => $user->getId()]);

        $dispatcher->dispatch(UserCreatedEvent::NAME, new UserCreatedEvent($user));

        return $response->created([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * @Route("/login", name="post_login", methods={"POST"})
     *
     * @param Request $request
     * @param ResponseInterface $response
     * @param TokenInterface $tokenManager
     * @return Response
     */
    public function login(
        Request $request,
        ResponseInterface $response,
        TokenInterface $tokenManager
    ): Response
    {
        $token = $tokenManager->encode(['id' => 53]);

        return $response->success(['token' => $token]);
    }
}
