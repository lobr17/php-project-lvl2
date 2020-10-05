<?php

namespace Differ\Differ\Differ;

use function Differ\Differ\Parsers\parses;
use function Differ\Differ\Parsers\getFormatFile;
use function Differ\Differ\Diff\getDiff;
use function Differ\Differ\Render\addOuterBreckets;
use function Differ\Differ\Render\getFormattedDiff;
use function Differ\Differ\Plain\plain;


function getFormatRequest($formatRequest, $tree)
{
    if ($formatRequest === 'pretty') {
        return getFormattedDiff($tree);
    } elseif ($formatRequest === 'plain') {
        return plain($tree, 3, $parent = null);
    }
}

function comparison($firstFile, $secondFile, $formatRequest)
{
        $fileFormat1 = getFormatFile($firstFile);
        $array1 = parses($firstFile, $fileFormat1);

        $fileFormat2 = getFormatFile($secondFile);
        $array2 = parses($secondFile, $fileFormat2);

	$tree = getDiff($array1, $array2);

        return getFormatRequest($formatRequest, $tree);
}

