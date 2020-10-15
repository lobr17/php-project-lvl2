<?php

namespace Differ\Differ\FormatRequest;

use Exception;

use function Differ\Differ\Pretty\getFormattedDiff as getPretty;
use function Differ\Differ\Plain\getFormattedDiff as getPlain;

function getFormatRequest($formatRequest, $tree)
{
    if ($formatRequest === 'pretty') {
        return getPretty($tree);
    } elseif ($formatRequest === 'plain') {
          return getPlain($tree);
    }
    throw new \Exception("There is no such input format '${formatRequest}'");
}
