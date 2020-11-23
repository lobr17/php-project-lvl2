<?php

namespace Differ\Formatters\Pretty;

use Exception;

function getFormattedDiff($tree)
{
    return iter($tree, 1);
}

function iter($tree, $depth)
{
    $tab = createTab($depth * 4 - 2);
    $closeTab = createTab($depth * 4 - 4);
    $childDepth = $depth + 1;

    $result = array_map(function ($node) use ($depth, $tab, $childDepth) {
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
                return "${tab}  {$node['name']}: " . iter($node['children'], $childDepth);

            default:
                throw new \Exception("Error. Not correct value type '${node['type']}'");
        }
    }, $tree);

    $resultString = implode("\n", $result);
    return "{\n${resultString}\n${closeTab}}";
}

function createTab($depth)
{
    return str_repeat(' ', $depth);
}

function getFormattedValue($value, $depth)
{

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (!is_array($value)) {
        if (is_null($value)) {
            return 'null';
        }
        return $value;
    }

    $newTab = createTab($depth * 4 + 4);
    $closeTab = createTab($depth * 4);

    $result = array_map(function ($key) use ($value, $depth, $newTab, $closeTab) {
        $formattedValue = getFormattedValue($value[$key], $depth + 1);
        return "${newTab}{$key}: {$formattedValue}";
    }, array_keys($value));

    return "{\n" . implode("\n", $result) . "\n${closeTab}}";
}
