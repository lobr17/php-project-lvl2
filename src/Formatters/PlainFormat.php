<?php

namespace Differ\Formatters\Plain;

use Exception;

use function Funct\Collection\flatten;

function getFormattedDiff($array)
{
    return iter($array, $parent = null) . "\n";
}

function iter($array, $parent)
{
    $lines = array_map(function ($node) use ($array, $parent) {
        $stringFullPath = "${parent}{$node['name']}";

        switch ($node['type']) {
            case 'removed':
                return "Property '${stringFullPath}' was removed";

            case 'add':
                $formattedValue = getFormattedValue($node['value']);
                return "Property '${stringFullPath}' was added with value: ${formattedValue}";

            case 'changed':
                $formattedOldValue = getFormattedValue($node['oldValue']);
                $formattedNewValue = getFormattedValue($node['newValue']);
                return "Property '${stringFullPath}' updated. From ${formattedOldValue} to ${formattedNewValue} "; // phpcs:ignore

            case 'nested':
                return iter($node['children'], $stringFullPath . ".");

            case 'unchanged':
                return [];

            default:
                throw new \Exception("Error. Not correct value type '${node['type']}'");
        }
    }, $array);
    $resultFlatten = flatten($lines);
    $result = implode("\n", $resultFlatten);
    return $result;
}

function getFormattedValue($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (!is_array($value)) {
        return "'${value}'";
    }
    return "[complex value]";
}