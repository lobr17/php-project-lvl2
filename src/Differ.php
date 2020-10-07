<?php

namespace Differ\Differ\Differ;

use function Differ\Differ\Parsers\parse;
use function Differ\Differ\Parsers\getFormatFile;
use function Differ\Differ\Diff\getDiff;
use function Differ\Differ\Pretty\addOuterBreckets;
use function Differ\Differ\Pretty\getFormattedDiff;
use function Differ\Differ\Plain\plain;

use Exception;

function getFormatRequest($formatRequest, $tree)
{
    try {    
	if ($formatRequest === 'pretty') {
            return getFormattedDiff($tree);
        } elseif ($formatRequest === 'plain') {
//            return plain($tree, 3, $parent = null);
              return plain($tree);  
	}
	throw new \Exception("Not correct format. \n");
    } catch (Exception $e) {
        echo "Error: {$e->getMessage()}";
    }
}

function comparison($firstFile, $secondFile, $formatRequest = 'pretty')
{
    $fileFormat1 = getFormatFile($firstFile);
    $array1 = parse($firstFile, $fileFormat1);

    $fileFormat2 = getFormatFile($secondFile);
    $array2 = parse($secondFile, $fileFormat2);

    $tree = getDiff($array1, $array2);

        return getFormatRequest($formatRequest, $tree);
}
