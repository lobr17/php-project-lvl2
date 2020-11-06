<?php

/**
 * Определение разности массивов.
 */

namespace Differ\TreeBuilder;

function getTree($data1, $data2)
{
    $keys1 = array_keys($data1);
    $keys2 = array_keys($data2);
    $keys = array_unique(array_merge($keys1, $keys2));
    asort($keys);
    $result = array_map(function ($key) use ($data1, $data2) {
        if (!array_key_exists($key, $data2)) {
            return ['name' => $key, 'type' => 'removed', 'value' => $data1[$key]];
        } elseif (!array_key_exists($key, $data1)) {
            return ['name' => $key, 'type' => 'add', 'value' => $data2[$key]];
        } elseif (is_array($data1[$key]) and is_array($data2[$key])) {
            return ['name' => $key, 'type' => 'nested', 'children' => getTree($data1[$key], $data2[$key])];
        } elseif ($data1[$key] === $data2[$key]) {
            return ['name' => $key, 'type' => 'unchanged', 'value' => $data1[$key]];
        } else {
            return ['name' => $key, 'type' => 'changed', 'oldValue' => $data1[$key], 'newValue' => $data2[$key]];
        }
    }, $keys);
    return $result;
}
