<?php

namespace App\Contract\Service\Token;

/**
 * Interface TokenInterface
 * @package App\Contract\Service\Token
 */
interface TokenInterface
{
    /**
     * @param string $token
     * @param array $allowedAlgs
     * @return object
     */
    public function decode(string $token, array $allowedAlgs = []): object;


    /**
     * @param array $payload
     * @param string $alg
     * @param null $keyId
     * @param null $head
     * @return string
     */
    public function encode(array $payload = [], string $alg, $keyId = null, $head = null) : string;
}
