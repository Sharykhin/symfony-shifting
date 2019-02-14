<?php

namespace App\Contract;

/**
 * Interface ArrayableInterface
 * @package App\Contract
 */
interface ArrayableInterface
{
    /**
     * @return array
     */
    public function toArray(): array;
}
