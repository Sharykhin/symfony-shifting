<?php

namespace App\Contract\Service\Invoice;

use App\ViewModel\InvoiceViewModel;

/**
 * Interface InvoiceCreateInterface
 * @package App\Contract\Service\Invoice
 */
interface InvoiceCreateInterface
{
    public function create(array $data) : InvoiceViewModel;
}
