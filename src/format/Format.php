<?php

namespace Differ\Format;

use Exception;

use function Differ\PrettyFormat\getFormattedDiff as getPretty;
use function Differ\PlainFormat\getFormattedDiff as getPlain;
use function Differ\Json\getOutputData as getJson;

function getFormat($formatName, $tree)
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
