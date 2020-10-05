<?php

namespace Differ\Differ\Plain;

use function Funct\Collection\flattenAll;

function plain($array, $depth, $parent)
{
    $result = array_map(function ($node) use ($depth, $array, $parent) {

        $sFullPath = "Property '{$parent}{$node['name']}'";
        

        if ($node['type'] === 'removed') {
            return "${sFullPath} was removed. \n";
        } elseif ($node['type'] === 'add') {
            return "${sFullPath} was added with value: " . getFormattedValue($node['value'], $depth) . "\n";
        } elseif ($node['type'] === 'changed') {
            //return "${sFullPath} updated. From " . getFormattedValue($node['oldValue'], $depth) . " to " . getFormattedValue($node['newValue'], $depth) . "\n";
            $oldValue = "${sFullPath} updated. From " . getFormattedValue($node['oldValue'], $depth);
            $newValue = getFormattedValue($node['newValue'], $depth) . "\n";
            return $oldValue . $newValue;
        } elseif ($node['type'] === 'nested') {
            return plain($node['children'], $depth + 5, $parent . $node['name'] . ".");
        }
    }, $array);

    $resultFlatten = flattenAll($result);

    $resultString = implode($resultFlatten);
        
    return $resultString;
}

function getFormattedValue($value, $depth)
{

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (!is_array($value)) {
        return $value;
    }

    return "[complex value]";
}
