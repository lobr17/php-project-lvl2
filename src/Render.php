<?php

/**
 *
 * Преобразование полученного массива в читаемый вид.
 */

namespace Differ\Differ\Render;

function render($array)
{
    //Делаем читаемый массив.
    $result = array_map(function ($child) {
        if ($child['type'] === '-') {
            if (!is_array($child['children'])) {
                return "{$child['type']}, {$child['name']}, {$child['children']}";
            } elseif (is_array($child['children'])) {
                return "{$child['type']}, {$child['name']}, " . "{" . "\n                 " . implode(array_keys($child['children'])) . ": " . implode($child['children']) . "\n" . "}";
            }
        } elseif ($child['type'] === '+') {
            if (!is_array($child['children'])) {
                return "{$child['type']}, {$child['name']}, {$child['children']}";
            } elseif (is_array($child['children'])) {
                return "{$child['type']}, {$child['name']}, " . "{" . "\n                 " . implode(array_keys($child['children'])) . ": " . implode($child['children']) . "\n" . "}";
            }
        } elseif ($child['type'] === 'has not changed') {
            if (!is_array($child['children'])) {
                return "{$child['type']}, {$child['name']}, {$child['children']}";
            } elseif (is_array($child['children'])) {
                return "{$child['type']}, {$child['name']}, " . "{" . "\n                 " . implode(array_keys($child['children'])) . ": " . implode($child['children']) . "\n" . "}";
            }
        } elseif ($child['type'] === 'changed') {
            if (!is_array($child['children'])) {
                return "{$child['type']}, {$child['name']}, {$child['children']}";
            } elseif (is_array($child['children'])) {
                return "{$child['type']}, {$child['name']}, " . "{" . "\n                 " . implode(array_keys($child['children'])) . ": " . implode($child['children']) . "\n" . "}";
            }
        } elseif ($child['type'] === 'nested') {
            unset($child['type']);

            $result = array_map(function ($subChild) use ($child) {
                if (is_array($subChild)) {
                    return render($subChild);
                }
            }, $child);
            return $result;
        }
    }, $array);

    //Массив переводим в строку.
    $resultRender = array_reduce($result, function ($acc, $child) {
            if (is_array($child)) {
                $acc .= implode(array_keys($child)) . ' {' . "\n" . implode($child) . '}' . "\n";
                return $acc;
            }
            $acc .= $child . "\n";
            return $acc;
    }, '');

    return $resultRender;
}

