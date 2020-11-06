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
    $firstFileData = file_get_contents($firstFileName);
    $firstData = parse($firstFileData, $firstFileFormat);

    $secondFileFormat = getFormatFile($secondFileName);
    $secondFileData = file_get_contents($secondFileName);
    $secondData = parse($secondFileData, $secondFileFormat);

    $tree = getTree($firstData, $secondData);

    return format($formatName, $tree);
}
