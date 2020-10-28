<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\TreeBuilder\getTree;
use function Differ\Format\format;

function getFormatFile($fileName)
{
    return pathinfo($fileName, PATHINFO_EXTENSION);
}


function compareFiles($firstFileName, $secondFileName, $formatName = 'pretty')
{
    $firstFileFormat = getFormatFile($firstFileName);
    $firstData = parse($firstFileName, $firstFileFormat);

    $secondFileFormat = getFormatFile($secondFileName);
    $secondData = parse($secondFileName, $secondFileFormat);

    $tree = getTree($firstData, $secondData);

    return format($formatName, $tree);
}
