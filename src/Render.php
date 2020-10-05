<?php

/**
 * Преобразование полученного массива в читаемый вид.
 */

namespace Differ\Differ\Render;

use function Funct\Collection\flattenAll;

function iter($array, $depth)
{
    $tub = str_repeat(' ', $depth);

    $result = array_map(function ($node) use ($depth, $tub) {
        if ($node['type'] === 'removed') {
            return  str_repeat(' ', $depth) . "- {$node['name']}: " . getFormattedValue($node['value'], $depth);
        } elseif ($node['type'] === 'add') {
            return  str_repeat(' ', $depth) . "+ {$node['name']}: " . getFormattedValue($node['value'], $depth);
        } elseif ($node['type'] === 'unchanged') {
            return str_repeat(' ', $depth + 1) . " {$node['name']}: " . getFormattedValue($node['value'], $depth);
        } elseif ($node['type'] === 'changed') {
                return "${tub}- ${node['name']}: " . getFormattedValue($node['oldValue'], $depth) . "\n" . "${tub}" . "+ {$node['name']}: " . getFormattedValue($node['newValue'], $depth);
        } elseif ($node['type'] === 'nested') {
            return "${tub} {$node['name']}: { \n" . iter($node['children'], $depth + 3) . "${tub}}";
        }
    }, $array);

    $resultString = implode("\n", $result) . "\n";
    return $resultString;
}

function getFormattedDiff($array)
{
    return "{\n" . iter($array, 3) . "}\n";
}


function getFormattedValue($value, $depth)
{
        
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (!is_array($value)) {
        return $value;
    }
    
    $newDepth = $depth + 2;

    $result = array_map(function ($key) use ($value, $newDepth) {
        $tab = str_repeat(' ', $newDepth);
        $formattedValue = getFormattedValue($value[$key], $newDepth);
        return str_repeat(' ', $newDepth) . "{$tab}{$key}:  {$formattedValue} "  ;
    }, array_keys($value));

    return "{\n"  . implode("\n", $result) . "\n"  . str_repeat(' ', $newDepth) . "}"  ;
}
