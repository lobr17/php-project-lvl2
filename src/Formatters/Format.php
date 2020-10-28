<?php

namespace Differ\Format;

use Exception;

use function Differ\Formatters\Pretty\getFormattedDiff as getPretty;
use function Differ\Formatters\Plain\getFormattedDiff as getPlain;

function format($formatName, $tree)
{
    if ($formatName === 'pretty') {
        return getPretty($tree);
    } elseif ($formatName === 'plain') {
        return getPlain($tree);
    } elseif ($formatName === 'json') {
        return json_encode($tree, true);
    }
    throw new \Exception("There is no such input format '${formatName}'");
}
