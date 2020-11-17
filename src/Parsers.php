<?php

/**
 * Парсинг.
 */

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;
use Exception;

function parse($data, $format)
{
    if ($format === 'json') {
        return json_decode($data, true);
    } elseif ($format === 'yml') {
        return Yaml::parse($data);
    }
    throw new \Exception("Format '${format}' cannot be processed.");
}
