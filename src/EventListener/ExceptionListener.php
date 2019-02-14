<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Contract\Service\Response\ResponseInterface;
use Psr\Log\LoggerInterface;

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

    /** @var TranslatorInterface $translator */
    protected $translator;

    /**
     * ExceptionListener constructor.
     * @param ContainerInterface $container
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     * @param TranslatorInterface $translator
     */
    public function __construct(
        ContainerInterface $container,
        ResponseInterface $response,
        LoggerInterface $logger,
        TranslatorInterface $translator
    )
    {
        $this->container = $container;
        $this->response = $response;
        $this->logger = $logger;
        $this->translator = $translator;
    }
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $environment = $this->container->getParameter('kernel.environment');
        $exception = $event->getException();

        if ($environment === 'dev' && $event->getRequest()->query->get('_mode') === 'prod' || $environment === 'prod') {
            $this->logger->error($exception->getMessage(), $exception->getTrace());

            switch ($exception) {
                case $exception instanceof AccessDeniedHttpException:
                    $response = $this->response->forbidden($this->translator->trans('Access Denied'));
                    break;
                default:
                    if (method_exists($exception, 'getStatusCode')) {
                        $response = $this->response->error($exception->getMessage(), $exception->getStatusCode());
                    } else {
                        $response = $this->response->error($exception->getMessage());
                    }
            }

            $event->setResponse($response);
        }
    }
}
