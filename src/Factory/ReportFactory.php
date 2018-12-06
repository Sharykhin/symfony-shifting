<?php

namespace App\Factory;

use App\Contract\Factory\ReportFactoryInterface;
use App\Entity\Report;

/**
 * Class ReportFactory
 * @package App\Factory
 */
class ReportFactory implements ReportFactoryInterface
{
    /**
     * @return Report
     */
    public function create() : Report
    {
        return new Report();
    }
}
