<?php

/**
 *
 * Преобразование полученного массива в читаемый вид.
 */

namespace Differ\Differ\Render;


//use Illuminate\Support\Collection;

function iter($array, $depth)
{
//	print_r($array);


    $result = array_map(function ($node) use ($depth)  {
        if ($node['type'] === 'removed') {
            return  str_repeat(' ', $depth) . "- {$node['name']}: " . getFormattedValue($node['value'], $depth);

        } elseif ($node['type'] === 'add') {
            return  str_repeat(' ', $depth) . "+ {$node['name']}: " . getFormattedValue($node['value'], $depth);
        // Одинаковые значения
        } elseif ($node['type'] === 'unchanged') {
            return str_repeat(' ', $depth + 1) ." {$node['name']}: " . getFormattedValue($node['value'], $depth);

        // Разные значения (хоть строки, хоть объекты)
        } elseif ($node['type'] === 'changed') {
                return str_repeat(' ', $depth) . "- {$node['name']}: " .   getFormattedValue($node['oldValue'], $depth) . "\n" . str_repeat(' ', $depth)  . "+ {$node['name']}: " . getFormattedValue($node['newValue'], $depth ) ;

        // Одинаковые ключи, значения объект
	} elseif ($node['type'] === 'nested') {
            return str_repeat(' ', $depth) . " {$node['name']}: { \n" . iter($node['children'][$node['name']], $depth + 3) . str_repeat(' ', $depth )  . "}";
        }
    }, $array);

    $collection = collect($result);
    $flattened = $collection->flatten();
    $flattened->all();

print_r($flattened);
   

    // Полученный массив переводим в строку
    $resultRender = array_reduce($result, function ($acc, $node) use ($depth) {
        if (is_array($node)) {
            $acc .=  implode($node) . "\n";
            return $acc ;
        }

        $acc .= $node . "\n";
        return $acc;
    }, '');
    

        return $resultRender;
    
}

function getFormattedDiff($array) {
    return iter($array, 3);
}


// Получаем значение Value и ноды (копаем вглубь)
function getFormattedValue($subArray, $depth) {
       
    // Проверка значения булева

// Тернарный с return не отрабатывает. Не получается выправить   
    if (!is_array($subArray)) {
        if (is_bool($subArray)) {
            if ($subArray === true) {
                return 'true';
            }
            return 'false';
        }

        return $subArray;
    }

    //----------------!!!!!!!!!!!!!!-------------------
    $newDepth = $depth + 5;

    $result = array_map(function ($key) use ($subArray, $newDepth) {
        $tab = str_repeat(' ', $newDepth);
        $formattedValue = getFormattedValue($subArray[$key], $newDepth);
        return str_repeat(' ', $newDepth) . "{$tab}{$key}:  {$formattedValue} "  ;
    }, array_keys($subArray));

    return "{\n"  . implode("\n", $result) . "\n"  . str_repeat(' ', $newDepth) . "}"  ;
}


function addOuterBreckets($withoutArray)
{
    return "{\n" . $withoutArray . "}\n";
}

