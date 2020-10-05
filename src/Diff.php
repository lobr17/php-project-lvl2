<?php

/**
 * Определение разности массивов.
 */

namespace Differ\Differ\Diff;

function getDiff($array1, $array2)
{
    $keys1 = array_keys($array1);
    $keys2 = array_keys($array2);
    $keys = array_unique(array_merge($keys1, $keys2));
    asort($keys);
    
    $result = array_map(function ($key) use ($array1, $array2) {
        // Удалённый, ключ есть только в before
        if (!array_key_exists($key, $array2)) {
            return ['name' => $key, 'type' => 'removed', 'value' => $array1[$key]];

            // Добавленный, ключ есть только в after
        } elseif (!array_key_exists($key, $array1)) {
            return ['name' => $key, 'type' => 'add', 'value' => $array2[$key]];

            // Одинаковые ключи. Значения объекты.
        } elseif (is_array($array1[$key]) and is_array($array2[$key])) {
            return ['name' => $key, 'type' => 'nested', 'children' => [$key => getDiff($array1[$key], $array2[$key])]];
        } elseif ($array1[$key] === $array2[$key]) {
            return ['name' => $key, 'type' => 'unchanged', 'value' => $array1[$key]];
        } else {
            return ['name' => $key, 'type' => 'changed', 'oldValue' => $array1[$key], 'newValue' => $array2[$key]];
        }
    }, $keys);
    
    return $result;
}
