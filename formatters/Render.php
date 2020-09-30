<?php

/**
 * Преобразование полученного массива в читаемый вид.
 */

namespace Differ\Differ\Render;


use function Funct\Collection\flattenAll;

function iter($array, $depth)
{
    $result = array_map(function ($node) use ($depth) {
        if ($node['type'] === 'removed') {
            return  str_repeat(' ', $depth) . "- {$node['name']}: " . getFormattedValue($node['value'], $depth);

        } elseif ($node['type'] === 'add') {
            return  str_repeat(' ', $depth) . "+ {$node['name']}: " . getFormattedValue($node['value'], $depth);
            // Одинаковые значения
        } elseif ($node['type'] === 'unchanged') {
            return str_repeat(' ', $depth + 1) ." {$node['name']}: " . getFormattedValue($node['value'], $depth);

            // Разные значения (хоть строки, хоть объекты)
        } elseif ($node['type'] === 'changed') {
                return str_repeat(' ', $depth) . "- {$node['name']}: " .   getFormattedValue($node['oldValue'], $depth) . "\n" . str_repeat(' ', $depth)  . "+ {$node['name']}: " .getFormattedValue($node['newValue'], $depth);

            // Одинаковые ключи, значения объект
        } elseif ($node['type'] === 'nested') {
            return str_repeat(' ', $depth) . " {$node['name']}: { \n" . iter($node['children'][$node['name']], $depth + 3).str_repeat(' ', $depth )  . "}";
        }
    }, $array);


    $resultString = implode("\n", $result) . "\n";
    return $resultString;
}

function getFormattedDiff($array) {
    return iter($array, 3);
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
	
 

    $newDepth = $depth + 2;

    $result = array_map(function ($key) use ($value, $newDepth) {
        $tab = str_repeat(' ', $newDepth);
        $formattedValue = getFormattedValue($value[$key], $newDepth);
        return str_repeat(' ', $newDepth) . "{$tab}{$key}:  {$formattedValue} "  ;
    }, array_keys($value));

    return "{\n"  . implode("\n", $result) . "\n"  . str_repeat(' ', $newDepth) . "}"  ;
}


function addOuterBreckets($withoutArray)
{
    return "{\n" . $withoutArray . "}\n";
}
