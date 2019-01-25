<?php

namespace App\Request\Type\Invoice;

use App\Request\Type\AbstractType;

/**
 * Class InvoiceCreateType
 * @package App\Request\Type\Invoice
 */
class InvoiceCreateType extends AbstractType
{
    /** @var mixed|null  */
    public $userId;

    /** @var mixed|null  */
    public $amount;

    /** @var mixed|null  */
    public $comment;

    /**
     * InvoiceCreateType constructor.
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        $this->userId = $fields['user_id'] ?? null;
        $this->amount = $fields['amount'] ?? null;
        $this->comment = $fields['comment'] ?? null;
    }
}
