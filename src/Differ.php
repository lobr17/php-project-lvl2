<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\TreeBuilder\getTree;
use function Differ\Format\format;

function getFormatData($fileName)
{
    return pathinfo($fileName, PATHINFO_EXTENSION);
}

function compareFiles($firstFileName, $secondFileName, $formatName = 'pretty')
{
    $firstFormat = getFormatData($firstFileName);
    $firstFileData = file_get_contents($firstFileName);
    $firstData = parse($firstFileData, $firstFormat);

    $secondFormat = getFormatData($secondFileName);
    $secondFileData = file_get_contents($secondFileName);
    $secondData = parse($secondFileData, $secondFormat);

    $tree = getTree($firstData, $secondData);

    return format($formatName, $tree);
}
