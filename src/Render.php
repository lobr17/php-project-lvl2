<?php

/**
 *
 * Преобразование полученного массива в читаемый вид.
 */

namespace Differ\Differ\Render;

function render($array)
{
    $result = array_map(function ($child) {
        if ($child['type'] === '-') {
            return "{$child['type']}, {$child['name']}, {$child['children']}";
        } elseif ($child['type'] === '+') {
            return "{$child['type']}, {$child['name']}, {$child['children']}";
        } elseif ($child['type'] === 'has not changed') {
            return "{$child['type']}, {$child['name']}, {$child['children']}";
        } elseif ($child['type'] === 'changed') {
            return "{$child['type']}, {$child['name']}, {$child['children']}";
        } elseif ($child['type'] === 'nested') {
            unset($child['type']);
         //   $key = array_keys($child);
           // print_r($key);

            $result = array_map(function ($subChild) use ($child) {
                if (is_array($subChild)) {
                    return render($subChild);
                }
            }, $child);

            return $result;
        }
    }, $array);

    return $result;
}

