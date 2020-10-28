<?php

namespace Differ\Formatters\Json;

function getOutputData($array)
{
     return json_encode($array, true);
}
