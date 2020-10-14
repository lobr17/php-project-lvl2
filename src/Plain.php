<?php

namespace Differ\Differ\Plain;

use function Funct\Collection\flattenAll;
use function Funct\Collection\compact;

use Exception;

function iter($array, $depth, $parent)
{
    $result = array_map(function ($node) use ($depth, $array, $parent) {
        $stringFullPath = "${parent}.{$node['name']}";
        
        switch ($node['type']) {
            case 'removed':
                return "Property '${stringFullPath}' was removed";
            break;

            case 'add':
                $formattedValue = getFormattedValue($node['value'], $depth);
                return "Property '${stringFullPath}' was added with value: ${formattedValue}";
                break;

            case 'changed':
                $formattedOldValue = getFormattedValue($node['oldValue'], $depth);
                $formattedNewValue = getFormattedValue($node['newValue'], $depth);
                $stringOldValue = "Property '${stringFullPath}' updated. From ${formattedOldValue} ";
                $stringNewValue = " to ${formattedNewValue} ";
                return $stringOldValue . $stringNewValue;
            break;

            case 'nested':
                return iter($node['children'], $depth + 5, $stringFullPath);
            break;

            case 'unchanged':
                break;

            default:
                Print_r("Error ${node['type']} \n");
        }
    }, $array);
    $resultFlatten = compact(flattenAll($result));
    $resultString = implode("\n", $resultFlatten);
    return $resultString;
}

function plain($array)
{
    return iter($array, 3, $parent = null) . "\n";
}


function getFormattedValue($value, $depth)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (!is_array($value)) {
        return "'${value}'";
    }
    return "[complex value]";
}
