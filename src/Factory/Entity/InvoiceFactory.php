<?php

namespace App\Factory\Entity;

use App\Contract\Factory\Entity\InvoiceFactoryInterface;
use App\Entity\Invoice;

/**
 * Class InvoiceFactory
 * @package App\Factory\Entity
 */
class InvoiceFactory implements InvoiceFactoryInterface
{
    /**
     * @return Invoice
     */
    public function create() : Invoice
    {
        return new Invoice();
    }
}
