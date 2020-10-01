<?php

/**
 * Определение разности массивов.
 */

namespace Differ\Differ\Diff;

function getDiff($array1, $array2)
{
    $keys1 = array_keys($array1);
    $keys2 = array_keys($array2);
    $arrayKeys = array_unique(array_merge($keys1, $keys2));
    asort($arrayKeys);
    
    $result =array_map(function ($key) use ($array1, $array2, $keys1, $keys2){
        // Удалённый, ключ есть только в before
        if (!in_array($key, $keys2)) {
            return ['name' => $key, 'type' => 'removed', 'value' => $array1[$key]];

            // Добавленный, ключ есть только в after
        } elseif (!in_array($key, $keys1)) {
            return ['name' => $key, 'type' => 'add', 'value' => $array2[$key]];

            // Одинаковые ключи. Значения объекты.
        } elseif (is_array($array1[$key]) and is_array($array2[$key])) {
            return ['name' => $key, 'type' => 'nested', 'children' => [$key => getDiff($array1[$key], $array2[$key])]];
        } elseif ($array1[$key] === $array2[$key]) {
            return ['name' => $key, 'type' => 'unchanged', 'value' => $array1[$key]];
        } else {
            return ['name' => $key, 'type' => 'changed', 'oldValue' => $array1[$key], 'newValue' => $array2[$key]];
        }
    }, $arrayKeys);
    
    return $result;
}
