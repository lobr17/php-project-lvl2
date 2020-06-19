<?php

/**
 *
 * Определение разности файлов.
 */

namespace Differ\Differ\diff;

require_once __DIR__ . "/../vendor/autoload.php";

use Symfony\Component\Yaml\Yaml;
use Differ\Differ\parsers;

function diffArray($array1, $array2)
{

    $collection1 = collect($array1);
    $collection2 = collect($array2);

//одинаковые ключи и значения
    $diff1 = $collection1->intersectByKeys($array2)->intersect($array2);
    $multiplied1 = $diff1->map(function ($item, $key) {
        return "{$key}: {$item}";
    })
    ->values()
    ->all();

//after при одинаковых ключах, но разных значениях
    $diff2 = $collection2->intersectByKeys($array1)->diffAssoc($array1);
    $multiplied2 = $diff2->map(function ($item, $key) {
        return "+ {$key}: {$item}";
    })
    ->values()
    ->all();

//before при одинаковых ключах, но разных значениях
    $diff3 = $collection1->intersectByKeys($array2)->diffAssoc($array2);
    $multiplied3 = $diff3->map(function ($item, $key) {
        return "- {$key}: {$item}";
    })
    ->values()
    ->all();

//есть в before, но нет в after.
    $diff4 = $collection1->diffKeys($array2);
    $multiplied4 = $diff4->map(function ($item, $key) {
        return "- {$key}: {$item}";
    })
    ->values()
    ->all();

//нет в before, но есть в after.
    $diff5 = $collection2->diffKeys($array1);
    $multiplied5 = $diff5->map(function ($item, $key) {
        return "+ {$key}: {$item}";
    })
    ->values()
    ->all();

//собираем все массивы и преобразуем в строку.
    $result1 = collect($multiplied1);
    $result = $result1->merge($multiplied2)->merge($multiplied3)->merge($multiplied4)->merge($multiplied5)->implode("\n");

    return $result;
}


function genDiff($nameFile1, $nameFile2)
{
    [$pathToFile1, $pathToFile2] = getPathToFile($nameFile1, $nameFile2);

    [$before, $after] = getFormatDecoder($pathToFile1, $pathToFile2);

    $outputString = diffArray($before, $after);

    return $outputString . "\n";
}
