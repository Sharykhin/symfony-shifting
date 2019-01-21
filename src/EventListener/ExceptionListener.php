<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Contract\Service\Response\ResponseInterface;

/**
 * Class AppExceptionListener
 * @package AppBundle\EventListener
 */
class ExceptionListener
{
    /** @var ContainerInterface $container */
    protected $container;

    /** @var ResponseInterface $response */
    protected $response;

    /**
     * ExceptionListener constructor.
     * @param ContainerInterface $container
     * @param ResponseInterface $response
     */
    public function __construct(
        ContainerInterface $container,
        ResponseInterface $response
    )
    {
        $this->container = $container;
        $this->response = $response;
    }
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event) : void
    {
        $exception = $event->getException();

        if ($exception instanceof AccessDeniedHttpException) {

            $response = $this->response->forbidden($exception->getMessage());
            $event->setResponse($response);
        }
    }
}
