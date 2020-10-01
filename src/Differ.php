<?php

namespace Differ\Differ\Differ;

use function Differ\Differ\Parsers\getArrayForTree;
use function Differ\Differ\Diff\getDiff;
use function Differ\Differ\Render\addOuterBreckets;
use function Differ\Differ\Render\getFormattedDiff;
use function Differ\Differ\formatters\Plain\plain;

function creatureTree($args)
{
        $array1 = getArrayForTree($args['<firstFile>']);
        $array2 = getArrayForTree($args['<secondFile>']);

        $tree = getDiff($array1, $array2);

        return $tree;
}

function getFormat($format, $tree)
{
    if ($format === 'pretty') {
        $recursion = getFormattedDiff($tree);
        return addOuterBreckets($recursion);
    } elseif ($format === 'plain') {
        return plain($tree, 3, $parent = null);
    }
}


function changedFormat($args)
{
        $tree = creatureTree($args);
        $result = getFormat($args['--format'], $tree);
        print_r($result);
}
