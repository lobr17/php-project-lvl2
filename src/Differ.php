<?php

namespace Differ\Differ\Differ;

use function Differ\Differ\Parsers\parse;
use function Differ\Differ\TreeBuilder\getTree;
use function Differ\Differ\format\Format\getFormatRequest;

function getFormatFile($fileName)
{
    return pathinfo($fileName, PATHINFO_EXTENSION);
}


function compareFiles($firstFileName, $secondFileName, $formatRequest = 'pretty')
{
    $firstFileFormat = getFormatFile($firstFileName);
    $firstData = parse($firstFileName, $firstFileFormat);

    $secondFileFormat = getFormatFile($secondFileName);
    $secondData = parse($secondFileName, $secondFileFormat);

    $tree = getTree($firstData, $secondData);

    return getFormatRequest($formatRequest, $tree);
}
