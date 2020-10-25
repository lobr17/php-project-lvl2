<?php

namespace Differ\Plain;

use Exception;

use function Funct\Collection\flatten;

function getOutputData($array, $parent)
{
    $result = array_map(function ($node) use ($array, $parent) {
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
                return getOutputData($node['children'], $stringFullPath . ".");

            case 'unchanged':
                return [];

            default:
                Print_r("Error. Not correct value type '${node['type']}'");
        }
    }, $array);
    $resultFlatten = flatten($result);
    $resultString = implode("\n", $resultFlatten);
    return $resultString;
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
