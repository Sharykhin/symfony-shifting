<?php

namespace App\Request\Constraint;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class AbstractConstrain
 * @package App\Request\Constraint
 */
abstract class AbstractConstrain
{
    /**
     * @return Assert\Collection
     */
    abstract public function getConstrain(): Assert\Collection;
}
