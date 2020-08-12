<?php

/**
 *
 * Определение разности файлов.
 */

namespace Differ\Differ\diff;

//require_once __DIR__ . "/../vendor/autoload.php";

use Symfony\Component\Yaml\Yaml;
use function Differ\Differ\parsers\getPathToFile;
use function Differ\Differ\parsers\getFormatDecoder;


function diffArray($array1, $array2, $option = null)
{

	$keys1 = array_keys($array1);
    $keys2 = array_keys($array2);
    $fish = array_unique(array_merge($keys1, $keys2));

    $result = array_map(function ($key) use ($array1, $array2, $keys1, $keys2, $option) {
        //ключ есть только в before.
        if (!in_array($key, $keys2)) {
            return ['name' => $key, 'type' => '-', 'children' => $array1[$key]];
        //ключ есть только в after.
        } elseif (!in_array($key, $keys1)) {
            return ['name' => $key, 'type' => '+', 'children' => $array2[$key]];
        //одинаковые ключи.
        } elseif (in_array($key, $keys1) and in_array($key, $keys2)) {
            //значения НЕ объекты.
            if (!is_array($array1[$key]) and !is_array($array2[$key])) {
                if ($array1[$key] === $array2[$key]) {
                    return ['name' => $key, 'type' => 'has not changed', 'children' => $array1[$key]];
                } elseif ($array1[$key] !== $array2[$key]) {
                    return ['name' => $key, 'type' => 'changed', 'children' => '-' . $array1[$key] . ' +' . $array2[$key]];
                }
             //значения объекты.
            } elseif (is_array($array1[$key]) and is_array($array2[$key])) {
                return [$key => diffArray($array1[$key], $array2[$key]), 'type' => 'nested'];
            }
        }
    }, $fish);
    return $result;
}

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
            
            $result = array_map(function ($subChild) {
                if (is_array($subChild)) {
                    return render($subChild);
                }
            }, $child);
            
            return $result;
        }
       // print_r(nl2br(PHP_EOL));
    }, $array);

    return $result;
}


function genDiff($nameFile1, $nameFile2)
{
    [$pathToFile1, $pathToFile2] = getPathToFile($nameFile1, $nameFile2);

    [$before, $after] = getFormatDecoder($pathToFile1, $pathToFile2);

    $outputString = diffArray($before, $after);

    return render($outputString);
}
