<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;
use function Differ\TreeBuilder\getTree;
use function Differ\Format\format;

function getFormatData($fileName)
{
    return pathinfo($fileName, PATHINFO_EXTENSION);
}

function compareFiles($firstName, $secondName, $nameFormat = 'pretty')
{
    $firstFormat = getFormatData($firstName);
    $firstFileData = file_get_contents($firstName);
    $firstData = parse($firstFileData, $firstFormat);

    $secondFormat = getFormatData($secondName);
    $secondFileData = file_get_contents($secondName);
    $secondData = parse($secondFileData, $secondFormat);

    $tree = getTree($firstData, $secondData);

    return format($nameFormat, $tree);
}
