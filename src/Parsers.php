<?php

/**
 * Парсинг.
 */

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;
use Exception;

function parse($fileData, $fileFormat)
{
    if ($fileFormat === 'json') {
        return json_decode($fileData, true);
    } elseif ($fileFormat === 'yml') {
        return Yaml::parse($fileData);
    }
    throw new \Exception("Format '${fileFormat}' cannot be processed.");
}
