<?php

namespace Differ\Differ\format\Format;

use Exception;

use function Differ\Differ\format\PrettyFormat\getFormattedDiff as getPretty;
use function Differ\Differ\format\PlainFormat\getFormattedDiff as getPlain;
use function Differ\Differ\format\JsonFormat\getFormattedDiff as getJson;

function getFormatRequest($formatName, $tree)
{
    if ($formatName === 'pretty') {
        return getPretty($tree);
    } elseif ($formatName === 'plain') {
        return getPlain($tree);
    } elseif ($formatName === 'json') {
        return getJson($tree);
    }
    throw new \Exception("There is no such input format '${formatName}'");
}
