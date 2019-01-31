<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
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

    /** @var LoggerInterface $logger */
    protected $logger;

    /**
     * ExceptionListener constructor.
     * @param ContainerInterface $container
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function __construct(
        ContainerInterface $container,
        ResponseInterface $response,
        LoggerInterface $logger
    )
    {
        $this->container = $container;
        $this->response = $response;
        $this->logger = $logger;
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

        $environment = $this->container->getParameter('kernel.environment');

        if ($environment === 'dev' && $event->getRequest()->query->get('_mode') === 'prod') {
            $this->logger->error($exception->getMessage(), $exception->getTrace());

            if (method_exists($exception, 'getStatusCode')) {
                $response = $this->response->error($exception->getMessage(), $exception->getStatusCode());
            } else {
                $response = $this->response->error($exception->getMessage());
            }

            $event->setResponse($response);
        }
    }
}
