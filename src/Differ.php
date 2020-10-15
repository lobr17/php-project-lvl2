<?php

namespace Differ\Differ\Differ;

use function Differ\Differ\Parsers\parse;
use function Differ\Differ\TreeBuilder\getTree;
use function Differ\Differ\FormatRequest\getFormatRequest;

function getFormatFile($fileName)
{
    return pathinfo($fileName, PATHINFO_EXTENSION);
}


function compareFiles($firstFileName, $secondFileName, $formatRequest = 'pretty')
{
    $firstFileFormat = getFormatFile($firstFileName);
    $dataFirstFile = parse($firstFileName, $firstFileFormat);

    $secondFileFormat = getFormatFile($secondFileName);
    $dataSecondFile = parse($secondFileName, $secondFileFormat);

    $tree = getTree($dataFirstFile, $dataSecondFile);

    return getFormatRequest($formatRequest, $tree);
}
