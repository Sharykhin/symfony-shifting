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
     * Creates a new Report entity
     *
     * @return Report
     */
    public function create(): Report;
}
