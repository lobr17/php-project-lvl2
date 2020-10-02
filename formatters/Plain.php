<?php

namespace Differ\Differ\formatters\Plain;

use function Funct\Collection\flattenAll;

function plain($array, $depth, $parent)
{
     // Убираю значения нод с типом unchanged
    $filteredArray = array_filter($array, function ($node) {
        if ($node['type'] !== 'unchanged') {
		return $node;
	}});

    $result = array_map(function ($node) use ($depth, $array, $parent) {
        if ($node['type'] === 'removed') {
            return "Property '" . $parent . $node['name'] . "'" . " was removed. \n";

        } elseif ($node['type'] === 'add') {
            return "Property '" . $parent .  $node['name'] .  "'" . " was added with value: " . getFormattedValue($node['value'], $depth) . "\n";

            // Разные значения (хоть строки, хоть объекты)
        } elseif ($node['type'] === 'changed') {
            return "Property '" . $parent . $node['name'] .  "'" . " updated. From " . getFormattedValue($node['oldValue'], $depth) . " to " .getFormattedValue($node['newValue'], $depth) . "\n";

            // Одинаковые ключи, значения объекты
        } elseif ($node['type'] === 'nested') {

            $result = array_map(function ($subNode) use ($node, $depth, $parent) {
                return plain($subNode , $depth + 5, $parent . $node['name'] . ".");
            }, $node['children']);

            return $result ;
        }
    }, $filteredArray);

    $resultFlatten = flattenAll($result);

    $resultString = implode($resultFlatten);
        
    return $resultString;
   
    
}

// Получаем значение Value и ноды (копаем вглубь)
function getFormattedValue($value, $depth) {
    
    // Проверка значения булева

    if (is_bool($value)) {
                return $value ? 'true' : 'false';
        }

        if (!is_array($value)) {
            return $value;
        }


    $newDepth = $depth + 3;

    $result = array_map(function ($key) use ($value, $newDepth) {

        $tab = str_repeat('&nbsp;', $newDepth);
        $formattedValue = getFormattedValue($value[$key], $newDepth);
        return "{$tab}{$key}:  {$formattedValue} ";
    }, array_keys($value));

    return "[complex value]";
}


