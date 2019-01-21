<?php

namespace App\Controller\API;

use App\Contract\Service\Mail\MailInterface;
use App\Event\UserCreatedEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Contract\Service\User\UserRetrieverInterface;
use App\Contract\Service\Response\ResponseInterface;
use App\Contract\Service\User\UserCreateInterface;

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
     */
    public function show(
        UserRetrieverInterface $userRetriever,
        ResponseInterface $response,
        int $userId
    ) : Response
    {
        $user = $userRetriever->findById($userId);

        if (is_null($user)) {
            // TODO: use translation package
            return $response->notFound('user was not found');
        }

        return $response->success($user);
    }

    /**
     * @Route("/users", name="post_user", methods={"POST"})
     *
     * @param Request $request
     * @param UserCreateInterface $userCreate
     * @param ResponseInterface $response
     * @param EventDispatcherInterface $dispatcher
     * @return Response
     */
    public function store(
        Request $request,
        UserCreateInterface $userCreate,
        ResponseInterface $response,
        EventDispatcherInterface $dispatcher
    ) : Response
    {
        $user = $userCreate->create($request->request->all());

        $dispatcher->dispatch(UserCreatedEvent::NAME, new UserCreatedEvent($user));

        return $response->created($user);
    }

    /**
     * @Route("/mail", name="get_mail", methods={"GET"})
     */
    public function mail(\Swift_Mailer $mailer, MailInterface $mail)
    {
//        $message = (new \Swift_Message('Hello Email'))
//            ->setFrom('send@example.com')
//            ->setTo('recipient@example.com')
//            ->setBody(
//                $this->renderView(
//                // templates/emails/registration.html.twig
//                    'emails/registration.html.twig',
//                    ['name' => 'Sergey']
//                ),
//                'text/html'
//            )
//        ;
//
//        $mailer->send($message);

        $mail->setSubject('Hello Email 2')
        ->setFrom('send@example.com', 'serg')
        ->setTo('recipient@example.com', 'Nasty')
        ->setBody( $this->renderView(
        // templates/emails/registration.html.twig
            'emails/registration.html.twig',
            ['name' => 'Sergey']
        ),
            'text/html')
        ->send();


        return $this->json([], JsonResponse::HTTP_OK);
    }
}
