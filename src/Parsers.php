<?php

/**
 * Парсинг.
 */

namespace Differ\Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function getExpansion($file)
{
    $expansion = pathinfo($file, PATHINFO_EXTENSION);
        return $expansion;
}

function getArrayForTree($file)
{
    $expansion = getExpansion($file);

    if ($expansion === 'json') {
            $workFile = json_decode(file_get_contents($file), true);
            return $workFile;
    } elseif ($expansion === 'yml') {
            $workFile = Yaml::parse(file_get_contents($file));
            return $workFile;
    }
}
