<?php

namespace App\Security;

use App\Contract\Service\Token\TokenInterface as InvoicerTokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Contract\Service\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

/**
 * Class JwtTokenAuthenticator
 * @package AppBundle\Security
 */
class JwtTokenAuthenticator extends AbstractGuardAuthenticator
{

    /** @var EntityManagerInterface $em */
    protected $em;

    /** @var InvoicerTokenInterface $tokenManager */
    protected $tokenManager;

    /** @var ResponseInterface $response */
    protected $response;

    /** @var TranslatorInterface $translator */
    protected $translator;

    /**
     * JwtTokenAuthenticator constructor.
     * @param EntityManagerInterface $em
     * @param InvoicerTokenInterface $tokenManager
     * @param ResponseInterface $response
     * @param TranslatorInterface $translator
     */
    public function __construct(
        EntityManagerInterface $em,
        InvoicerTokenInterface $tokenManager,
        ResponseInterface $response,
        TranslatorInterface $translator
    )
    {
        $this->em = $em;
        $this->tokenManager = $tokenManager;
        $this->response = $response;
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request): bool
    {
        return $request->headers->has('Authorization') && !empty($request->headers->get('Authorization'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getCredentials(Request $request)
    {
        $authHeader = $request->headers->get('Authorization');

        if (strpos(mb_strtolower($authHeader), 'bearer ') !== 0) {
            throw new AuthenticationException('Token in invalid it must have Bearer prefix');
        }

        $token = substr($authHeader, mb_strlen('Bearer '));

        return [
            'token' => $token,
        ];
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {

        $payload = $this->tokenManager->decode($credentials['token']);
        if (is_null($payload)) {
            return null;
        }

        $userId = $payload->sub->id;
        $user = $this->em->getRepository(User::class)->findOneById($userId);

        return $user;
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return $this->response->error($this->translator->trans($exception->getMessage()), Response::HTTP_FORBIDDEN);
    }

    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return $this->response->error($this->translator->trans('Authentication Required'), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
