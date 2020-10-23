<?php

namespace Differ\Differ\format\PrettyFormat;

use function Differ\Differ\Pretty\iter;

function getFormattedDiff($array)
{
    return iter($array, 1);
}
