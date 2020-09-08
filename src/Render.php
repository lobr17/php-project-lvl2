<?php

/**
 *
 * Преобразование полученного массива в читаемый вид.
 */

namespace Differ\Differ\Render;

function render($array, $depth)
{
    $result = array_map(function ($node) use ($depth)  {
        if ($node['type'] === 'removed') {
            return  str_repeat(' ', $depth) . "- " . $node['name'] . ": " . getFormattedValue($node['value'], $depth);

        } elseif ($node['type'] === 'add') {
            return  str_repeat(' ', $depth) . "+ " . $node['name'] . ": " . getFormattedValue($node['value'], $depth);

        // Одинаковые значения
        } elseif ($node['type'] === 'unchanged') {
            return str_repeat(' ', $depth) . $node['name'] . ": " . getFormattedValue($node['value'], $depth);

        // Разные значения (хоть строки, хоть объекты)
        } elseif ($node['type'] === 'changed') {
                return str_repeat(' ', $depth) . "- " . "{$node['name']}: " .   getFormattedValue($node['oldValue'], $depth) . "\n" . str_repeat(' ', $depth)  . "+ " . "{$node['name']}: " . getFormattedValue($node['newValue'], $depth ) ;

        // Одинаковые ключи, значения объекты
        } elseif ($node['type'] === 'nested') {

            $result = array_map(function ($subNode) use ($node, $depth) {
                    return str_repeat(' ', $depth ) . $node['name'] . ": {" . "\n" . render($subNode , $depth + 5) . str_repeat(' ', $depth ) . "}" ;
            }, $node['children']);

            return $result ;
        }
    }, $array);

    // Конечный массив переводим в строку.
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

// Получаем значение Value и ноды (копаем вглубь)
function getFormattedValue($subArray, $depth) {
    // Проверка значения булева
    if (!is_array($subArray)) {
        if (is_bool($subArray)) {
            if ($subArray === true) {
                return 'true';
            }
            return 'false';
        }

        return $subArray;
    }

    $newDepth = $depth + 3;

    $result = array_map(function ($key) use ($subArray, $newDepth) {
        $tab = str_repeat(' ', $newDepth);
        $formattedValue = getFormattedValue($subArray[$key], $newDepth);
        return str_repeat(' ', $newDepth) . "{$tab}{$key}:  {$formattedValue} "  ;
    }, array_keys($subArray));

    return "{\n"  . implode("\n", $result) . "\n"  . str_repeat(' ', $newDepth) . "}"  ;
}

// Наружные скобки
function converter($withoutArray)
{
    return "{\n" . $withoutArray . "}\n";
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

