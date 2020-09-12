<?php

namespace Dif\Dif\Formatters\Plain;

require_once __DIR__ . '/../vendor/autoload.php';

function plain($array, $depth, $parent)
{
    // Убираю значения нод с типом unchanged
    $filteredArray = array_filter($array, fn($node) => $node['type'] !== 'unchanged');

    $result = array_map(function ($node) use ($depth, $array, $parent)  {
        if ($node['type'] === 'removed') {
            return "'" . $parent . $node['name'] . "'" . " was removed.";

        } elseif ($node['type'] === 'add') {
            return "'" . $parent .  $node['name'] .  "'" . " was added with value: " . getFormattedValue($node['value'], $depth) ;

        // Разные значения (хоть строки, хоть объекты)
        } elseif ($node['type'] === 'changed') {
            return $parent . $node['name'] .  "'" . " updated. From " . getFormattedValue($node['oldValue'], $depth) . " to " . getFormattedValue($node['newValue'], $depth ) ;

            // Одинаковые ключи, значения объекты
        } elseif ($node['type'] === 'nested') {

            $result = array_map(function ($subNode) use ($node, $depth, $parent) {
                return plain($subNode , $depth + 5, $parent . $node['name'] . ".");
            }, $node['children']);

            return $result ;
        }
    }, $filteredArray);

    // Конечный массив переводим в строку.
    $resultRender = array_reduce($result, function ($acc, $node) use ($depth, $result) {
        if (is_array($node)) {
            $acc .= implode($node);
            return $acc;
        }
        $acc .=   "Property " . $node . nl2br(PHP_EOL);
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
        return "'" . $subArray . "'";
    }

    $newDepth = $depth + 3;

    $result = array_map(function ($key) use ($subArray, $newDepth) {

        $tab = str_repeat('&nbsp;', $newDepth);
        $formattedValue = getFormattedValue($subArray[$key], $newDepth);
        return "{$tab}{$key}:  {$formattedValue} ";
    }, array_keys($subArray));

    return "[complex value]";
}


//print_r(nl2br(PHP_EOL));



