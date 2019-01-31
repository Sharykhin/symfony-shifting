<?php

namespace App\Contract\Service\Invoice;

use App\ViewModel\InvoiceViewModel;

/**
 * Interface InvoiceRetrieverInterface
 * @package App\Contract\Service\Invoice
 */
interface InvoiceRetrieverInterface
{
    /**
     * @param int $id
     * @return InvoiceViewModel|null
     */
    public function findById(int $id): ?InvoiceViewModel;

    /**
     * @param array $criteria
     * @param array|null|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function getList(array $criteria = [], ?array $orderBy = null, $limit = null, $offset = null): array;

    /**
     * @param array $criteria
     * @return int
     */
    public function count(array $criteria = []): int;
}
