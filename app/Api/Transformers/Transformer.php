<?php

namespace App\Api\Transformers;

abstract class Transformer
{

    public function transformCollection(array $items) {
        return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);

    public function formatHtml($value)
    {
        $value = str_replace(["\\r\\n", "\r\n", "\t", "\n", "\r", "\\n", "\\r", "\\t"], ' ', $value);

        return ( ! $this->isEmptyOrNull($value)) ? trim($value) : null;
    }

    public function formatDecimalValue($value)
    {
        // show only 2-digit after decimal
        $formattedValue = number_format((float) $value, 2, '.', '');

        // next, replace the trailing .00 if exists in the value
        return str_replace(".00", "", (string) $formattedValue);
    }

    public function isEmptyOrNull($value)
    {
        return (is_null($value) || empty($value)) ? true : false ;
    }
}
