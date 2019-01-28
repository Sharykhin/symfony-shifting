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
     * @param array $data
     * @return InvoiceViewModel
     */
    public function create(array $data) : InvoiceViewModel
    {
        return new InvoiceViewModel($data);
    }
}
