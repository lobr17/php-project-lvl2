<?php

/**
 *
 *  diff.php
 *
 */


namespace Differ\Differ\diff;


function genDiff($pathToFile1, $pathToFile2)
{

    $before = json_decode(file_get_contents($pathToFile1), true);
    $after = json_decode(file_get_contents($pathToFile2), true);


    $result = [];

    foreach ($before as $keyBef => $valueBef) {
        foreach ($after as $keyAft => $valueAft) {
            if ($keyBef === $keyAft and $before[$keyBef] === $after[$keyAft]) {
                $result[] = $keyBef . ': ' . $valueBef;
            } elseif ($keyBef === $keyAft and $before[$keyBef] !== $after[$keyAft]) {
                $result[] = '+' . ' ' . $keyAft . ': ' . $valueAft;
                $result[] = '-' . ' ' . $keyBef . ': ' . $valueBef;
            } elseif (isset($before[$keyBef]) and empty($after[$keyBef])) {
                $result[] = '-' . ' ' . $keyBef . ':' . ' ' . $valueBef;
            } elseif (empty($before[$keyAft]) and isset($after[$keyAft])) {
                $result[] = '+' . ' ' . $keyAft . ':' . $valueAft;
            }
        }
    }
    $outputArray = array_unique($result);
    $outputString =  implode("\n", $outputArray);
    return $outputString . "\n";
}
