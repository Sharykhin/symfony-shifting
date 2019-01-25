<?php

namespace App\Contract\Factory\Entity;

use App\Entity\Invoice;

/**
 * Interface InvoiceFactoryInterface
 * @package App\Contract\Factory
 */
interface InvoiceFactoryInterface
{
    /**
     * @return Invoice
     */
    public function create() : Invoice;
}
