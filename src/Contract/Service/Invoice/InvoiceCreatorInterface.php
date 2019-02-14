<?php

namespace App\Contract\Service\Invoice;

use App\Request\Type\Invoice\InvoiceCreateType;
use App\ViewModel\InvoiceViewModel;

/**
 * Interface InvoiceCreatorInterface
 * @package App\Contract\Service\Invoice
 */
interface InvoiceCreatorInterface
{
    /**
     * @param InvoiceCreateType $type
     * @return InvoiceViewModel
     */
    public function create(InvoiceCreateType $type): InvoiceViewModel;
}
