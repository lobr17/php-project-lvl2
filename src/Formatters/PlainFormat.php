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
       
	$partsPath = [$parent, $node['name']];    
	$resultPath = array_diff($partsPath, ['']);
        $namePath = implode(".", $resultPath);

        switch ($node['type']) {
            case 'removed':
                return "Property '${namePath}' was removed";

            case 'add':
                $formattedValue = getFormattedValue($node['value']);
                return "Property '${namePath}' was added with value: ${formattedValue}";

            case 'changed':
                $formattedOldValue = getFormattedValue($node['oldValue']);
                $formattedNewValue = getFormattedValue($node['newValue']);
                return "Property '${namePath}' updated. From ${formattedOldValue} to ${formattedNewValue} "; // phpcs:ignore

            case 'nested':
                return iter($node['children'], $namePath);

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
