<?php

namespace App\Factory\ViewModel;

use App\Contract\Factory\ViewModel\InvoiceViewModelFactoryInterface;
use App\ViewModel\InvoiceViewModel;

/**
 * Class InvoiceViewModelFactory
 * @package App\Factory\ViewModel
 */
class InvoiceViewModelFactory implements InvoiceViewModelFactoryInterface
{
    /**
     * @return InvoiceViewModel
     */
    public function create() : InvoiceViewModel
    {
        return new InvoiceViewModel();
    }
}
