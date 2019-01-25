<?php

namespace App\Request\Constraint\Invoice;

use Symfony\Component\Validator\Constraints as Assert;
use App\Request\Constraint\AbstractConstrain;

/**
 * Class InvoiceCreateConstraint
 * @package App\Request\Constraint\Invoice
 */
class InvoiceCreateConstraint extends AbstractConstrain
{
    /**
     * @return Assert\Collection
     */
    public function getConstrain(): Assert\Collection
    {
        return new Assert\Collection([
            'groups' => ['creating', 'updating'],
            'fields' => [
                'user_id' => [
                    new Assert\NotBlank(['groups' => ['creating']]),
                    new Assert\Type(['groups' => ['creating'], 'type' => 'integer']),
                ],
                'amount' => [
                    new Assert\NotBlank(['groups' => ['creating']]),
                    new Assert\Type(['groups' => ['creating'], 'type' => 'float']),
                ],
                'comment' => [
                    new Assert\NotBlank(['groups' => ['creating']]),
                    new Assert\Type(['groups' => ['creating'], 'type' => 'string']),
                ],
            ],
            'allowMissingFields' => false,
            'allowExtraFields' => false
        ]);
    }
}
