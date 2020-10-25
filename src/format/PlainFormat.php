<?php

namespace Differ\PlainFormat;

use function Differ\Plain\getOutputData;

function getFormattedDiff($array)
{
    return getOutputData($array, $parent = null) . "\n";
}
