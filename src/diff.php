<?php

/**
 *
 * Определение разности файлов.
 */

namespace Differ\Differ\diff;

//require_once __DIR__ . "/../vendor/autoload.php";

function diffArray ($array1, $array2)
{
    $keys1 = array_keys($array1);
    $keys2 = array_keys($array2);
    $fish = array_unique(array_merge($keys1, $keys2));
    asort($fish);
    
    $result = array_map(function ($key) use ($array1, $array2, $keys1, $keys2) {

        // Удалённый, ключ есть только в before
        if (!in_array($key, $keys2)) {
                return ['name' => $key, 'type' => 'removed', 'value' => $array1[$key]];

        // Добавленный, ключ есть только в after
        } elseif (!in_array($key, $keys1)) {
            return ['name' => $key, 'type' => 'add', 'value' => $array2[$key]];

        // Одинаковые ключи
        } else {

            // Значения объекты (СРАВНИВАЕМ)
            if (is_array($array1[$key]) and is_array($array2[$key])) {
                return ['name' => $key, 'type' => 'nested', 'children' => [$key => diffArray($array1[$key], $array2[$key])]];

            // Значения объект и строка (РАЗНЫЕ)
            } elseif (is_array($array1[$key]) and !is_array($array2[$key]) or !is_array($array1[$key]) and is_array($array2[$key])) {
                    return ['name' => $key, 'type' => 'changed', 'oldValue' =>  $array1[$key], 'newValue' => $array2[$key]];

            // Значения строки
            } else {
                if ($array1[$key] === $array2[$key]) {
                    return ['name' => $key, 'type' => 'unchanged', 'value' => $array1[$key]];
                }
                return ['name' => $key, 'type' => 'changed', 'oldValue' => $array1[$key], 'newValue' =>$array2[$key]];
            }
        }
    }, $fish);
    // print_r(nl2br(PHP_EOL));
    return $result;
}
