<?php

/**
 *
 * Парсинг.
 */

namespace Differ\Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

use function Differ\Differ\Diff\getDiff;
use function Differ\Differ\Render\addOuterBreckets;
use function Differ\Differ\Render\getFormattedDiff;
use function Differ\Differ\formatters\Plain\plain;

function getExpansion($file)
{
    $expansion = pathinfo($file, PATHINFO_EXTENSION);
        return $expansion;
}

function getArrayForTree($file)
{
    $expansion = getExpansion($file);

    if ($expansion === 'json') {
            $workFile = json_decode(file_get_contents($file), true);
            return $workFile;
    } elseif ($expansion === 'yml') {
            $workFile = Yaml::parse(file_get_contents($file));
            return $workFile;
    }
}

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
//        print_r($result);
}
