<?php

namespace Differ\Differ\Plain;

use Exception;

use function Funct\Collection\flattenAll;
use function Funct\Collection\compact;

function iter($array, $parent)
{
    $result = array_map(function ($node) use ($array, $parent) {
        $stringFullPath = "${parent}{$node['name']}";

        switch ($node['type']) {
            case 'removed':
                return "Property '${stringFullPath}' was removed";
            break;

            case 'add':
                $formattedValue = getFormattedValue($node['value']);
                return "Property '${stringFullPath}' was added with value: ${formattedValue}";
                break;

            case 'changed':
                $formattedOldValue = getFormattedValue($node['oldValue']);
                $formattedNewValue = getFormattedValue($node['newValue']);
                return "Property '${stringFullPath}' updated. From ${formattedOldValue} to ${formattedNewValue} "; // phpcs:ignore
            break;

            case 'nested':
                return iter($node['children'], $stringFullPath . ".");
            break;

            case 'unchanged':
                break;

            default:
                Print_r("Error. Not correct value type '${node['type']}'");
        }
    }, $array);
    $resultFlatten = compact(flattenAll($result));
    $resultString = implode("\n", $resultFlatten);
    return $resultString;
}

function getFormattedDiff($array)
{
    return iter($array, $parent = null) . "\n";
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
