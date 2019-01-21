<?php

namespace App\Contract\Factory\Entity;

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
