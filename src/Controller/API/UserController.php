<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Contract\Service\User\UserRetrieverInterface;
use App\Contract\Service\Response\ResponseInterface;
use App\Contract\Service\Validate\ValidateInterface;
use App\Contract\Service\User\UserCreateInterface;
use App\Request\Constraint\User\CreateConstraint;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Request\Type\User\UserCreateType;
use App\ValueObject\ValidatorBag;
use App\ViewModel\UserViewModel;
use App\Event\UserCreatedEvent;

/**
 * Class UserController
 * @package App\Controller\API
 */
class UserController extends AbstractController
{
    /**
     * @Route("/users/{userId}", name="get_user", methods={"GET"}, requirements={"userId"="\d+"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
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
    ): Response
    {
        /** @var UserViewModel $user */
        $user = $userRetriever->findById($userId);

        if (is_null($user)) {
            return $response->notFound($translator->trans('User with id %id% was not found', ['%id%' => $userId]));
        }

        return $response->success($user);
    }

    /**
     * @Route("/users", name="post_users", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
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
    ): Response
    {
        $userCreateType = new UserCreateType($request->request->all());

        /** @var ValidatorBag $validatorBag */
        $validatorBag = $validate->validate(
            $userCreateType->toArray(),
            CreateConstraint::class,
            ['creating']
        );

        if (!$validatorBag->isValid()) {
            return $response->badRequest($validatorBag->getErrors());
        }

        if ($userRetriever->existsEmail($request->get('email'))) {
            return $response->badRequest(['email' => $translator->trans('User with such email already exists')]);
        }

        $user = $userCreate->create($userCreateType);

        $dispatcher->dispatch(UserCreatedEvent::NAME, new UserCreatedEvent($user));

        return $response->created($user);
    }
}
