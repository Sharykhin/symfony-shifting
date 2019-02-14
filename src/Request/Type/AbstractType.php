<?php

namespace App\Request\Type;

use App\Contract\ArrayableInterface;

/**
 * Class AbstractType
 * @package App\Request\Type
 */
abstract class AbstractType implements ArrayableInterface
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->camelCaseToSnakeCase((array) $this);
    }

    /**
     * @param array $items
     * @return array
     */
    protected function camelCaseToSnakeCase(array $items): array
    {
        $convertedItems = [];
        foreach ($items as $key => $value) {
            $convertedItems[from_camel_case($key)] = is_array($value) ? $this->camelCaseToSnakeCase($value) : $value;
        }

        return $convertedItems;
    }
}
