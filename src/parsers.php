<?php

/**
 *
 * Обработка пути к файлу + парсинг.
 */

namespace Differ\Differ\parsers;

use Symfony\Component\Yaml\Yaml;


function getPathToFile($nameFile1, $nameFile2)
{
    $folderWithFiles = './workfiles/';
    $pathToFile1 = $folderWithFiles . $nameFile1;
    $pathToFile2 = $folderWithFiles . $nameFile2;

    return [$pathToFile1, $pathToFile2];
}



function getFormatDecoder($pathToFile1, $pathToFile2)
{

    $expansion = pathinfo($pathToFile1, PATHINFO_EXTENSION);

    if ($expansion === 'json') {
        $parse = decoderJsonInPhp($pathToFile1, $pathToFile2);
    } elseif ($expansion === 'yml') {
        $parse = decoderYamlInPhp($pathToFile1, $pathToFile2);
    }

    return $parse;
}

function decoderYamlInPhp($pathToFile1, $pathToFile2)
{
    $before = Yaml::parse(file_get_contents(__DIR__ . '/../workfiles/' . $pathToFile1));
    $after = Yaml::parse(file_get_contents(__DIR__ . '/../workfiles/' . $pathToFile2));

    return [$before, $after];
}

function decoderJsonInPhp($pathToFile1, $pathToFile2)
{
    $before = json_decode(file_get_contents(__DIR__ . '/../workfiles/' . $pathToFile1), true);
    $after = json_decode(file_get_contents(__DIR__ . '/../workfiles/' . $pathToFile2), true);

    return [$before, $after];
}

