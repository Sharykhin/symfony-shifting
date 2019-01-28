<?php

namespace App\Contract\Factory\ViewModel;

use App\ViewModel\InvoiceViewModel;

/**
 * Interface InvoiceViewModelFactoryInterface
 * @package App\Contract\Factory\ViewModel
 */
interface InvoiceViewModelFactoryInterface
{
    /**
     * @param array $data
     * @return InvoiceViewModel
     */
    public function create(array $data) : InvoiceViewModel;
}
