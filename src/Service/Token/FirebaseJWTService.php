<?php

namespace App\Service\Token;

use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Contract\Service\Token\TokenInterface;
use Firebase\JWT\JWT;

/**
 * Class FirebaseJWTService
 * @package AppBundle\Service\Token
 */
class FirebaseJWTService implements TokenInterface
{
    /** @var ContainerInterface $container */
    protected $container;

    /**
     * FirebaseJWTService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container
    )
    {
        $this->container = $container;
    }
    /**
     * @param array $payload
     * @param string $alg
     * @param null $keyId
     * @param null $head
     * @return string
     */
    public function encode(array $payload = [], string $alg = 'HS256', $keyId = null, $head = null): string
    {
        $key = $this->container->getParameter('jwt_secret_key');
        $exp = $this->container->getParameter('jwt_token_exp');

        $token = array(
            "sub" => $payload,
            "exp" => time() + $exp
        );

        return JWT::encode($token, $key);
    }

    /**
     * @param string $jwt
     * @param array $allowedAlgs
     * @return object
     */
    public function decode(string $jwt, array $allowedAlgs = []): object
    {
        $key = $this->container->getParameter('jwt_secret_key');

        return JWT::decode($jwt, $key, ['HS256']);
    }
}