<?php

namespace Differ\Differ\format\JsonFormat;

use function Differ\Differ\Json\iter;

function getFormattedDiff($array)
{
    return iter($array);
}

