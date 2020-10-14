<?php

namespace Differ\Differ\Differ;

use function Differ\Differ\Parsers\parse;
use function Differ\Differ\Diff\getDiff;
use function Differ\Differ\Pretty\addOuterBreckets;
use function Differ\Differ\Pretty\getFormattedDiff;
use function Differ\Differ\Plain\plain;

use Exception;

function getFormatFile($fileName)
{
    return pathinfo($fileName, PATHINFO_EXTENSION);
}

function getFormatRequest($formatRequest, $tree)
{
    if ($formatRequest === 'pretty') {
        return getFormattedDiff($tree);
    } elseif ($formatRequest === 'plain') {
          return plain($tree);
    }
    throw new \Exception("There is no such input format. \n");
}

function comparison($firstFileName, $secondFileName, $formatRequest = 'pretty')
{
    $firstFileFormat = getFormatFile($firstFileName);
    $arrayFirstFile = parse($firstFileName, $firstFileFormat);

    $secondFileFormat = getFormatFile($secondFileName);
    $arraySecondFile = parse($secondFileName, $secondFileFormat);

    $tree = getDiff($arrayFirstFile, $arraySecondFile);

    return getFormatRequest($formatRequest, $tree);
}
