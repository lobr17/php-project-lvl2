<?php

/**
 * Преобразование полученного массива в читаемый вид.
 */

namespace Differ\Differ\Pretty;

function iter($array, $depth)
{
    $tab = createTab($depth);
    $closableTab = createTab($depth - 1);

    $result = array_map(function ($node) use ($depth, $tab) {
        switch ($node['type']) {
            case 'removed':
                $formattedValue = getFormattedValue($node['value'], $depth);
                return "${tab}- {$node['name']}: $formattedValue";

            case 'add':
                $formattedValue = getFormattedValue($node['value'], $depth);
                return "${tab}+ {$node['name']}: $formattedValue";

            case 'unchanged':
                $formattedValue = getFormattedValue($node['value'], $depth);
                return "${tab}  {$node['name']}: $formattedValue";

            case 'changed':
                $formattedOldValue = getFormattedValue($node['oldValue'], $depth);
                $formattedNewValue = getFormattedValue($node['newValue'], $depth);
                $removed = "${tab}- ${node['name']}: $formattedOldValue\n";
                $added = "${tab}+ {$node['name']}: $formattedNewValue";
                return $removed . $added;

            case 'nested':
                return " ${tab} {$node['name']}: " . iter($node['children'], $depth + 2);
        }
    }, $array);

    $resultString = implode("\n", $result);
    return "{\n" . $resultString . "\n${closableTab}}";
}

function createTab($depth)
{
    return str_repeat('  ', $depth);
}

function getFormattedValue($value, $depth)
{

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (!is_array($value)) {
        return $value;
    }

    $tab = createTab($depth);
    $newTab = createTab($depth + 2);
    $closableTab = createTab($depth + 1);

    $result = array_map(function ($key) use ($value, $depth, $tab, $newTab, $closableTab) {
        $formattedValue = getFormattedValue($value[$key], $depth + 1); // Blizko
        return "${newTab}{$key}: {$formattedValue}";
    }, array_keys($value));

    return "{\n" . implode("\n", $result) . "\n${closableTab}}";
}
