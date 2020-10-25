<?php

//namespace Differ\Differ\Differ;
namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\TreeBuilder\getTree;
use function Differ\Format\getFormat;

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

    return getFormat($formatRequest, $tree);
}
