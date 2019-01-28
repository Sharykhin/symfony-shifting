<?php

namespace App\Contract\Service\Invoice;

use App\ViewModel\InvoiceViewModel;

/**
 * Interface InvoiceRetrieverInterface
 * @package App\Contract\Service\Invoice
 */
interface InvoiceRetrieverInterface
{
    public function findById(int $id): ?InvoiceViewModel;
}
