<?php

/**
 * Парсинг.
 */

namespace Differ\Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function getFormatFile($fileName)
{
    return pathinfo($fileName, PATHINFO_EXTENSION);
}

function parse($fileName, $fileFormat)
{
    if ($fileFormat === 'json') {
            return json_decode(file_get_contents($fileName), true);
    } elseif ($fileFormat === 'yml') {
            return Yaml::parse(file_get_contents($fileName));
    }
}
