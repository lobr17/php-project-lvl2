<?php

/**
 * Парсинг.
 */

namespace Differ\Differ\Parsers;

use Symfony\Component\Yaml\Yaml;
use Exception;

function parse($fileName, $fileFormat)
{
    if ($fileFormat === 'json') {
            return json_decode(file_get_contents($fileName), true);
    } elseif ($fileFormat === 'yml') {
            return Yaml::parse(file_get_contents($fileName));
    }
    throw new \Exception("Format '${fileFormat}' cannot be processed.");
}
