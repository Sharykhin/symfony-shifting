<?php

namespace App\Contract\Factory;

use App\Entity\Report;

/**
 * Interface ReportFactoryInterface
 * @package App\Contract\Factory
 */
interface ReportFactoryInterface
{
    /**
     * @return Report
     */
    public function create() : Report;
}
