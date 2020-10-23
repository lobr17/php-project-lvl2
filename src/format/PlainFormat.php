<?php

namespace Differ\Differ\format\PlainFormat;

use function Differ\Differ\Plain\iter;

function getFormattedDiff($array)
{
    return iter($array, $parent = null) . "\n";
}
