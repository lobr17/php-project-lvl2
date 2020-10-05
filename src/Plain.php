<?php

namespace Differ\Differ\Plain;

use function Funct\Collection\flattenAll;

function plain($array, $depth, $parent)
{
    print_r($array);

    $filteredArray = array_filter($array, function ($node) {
        if ($node['type'] !== 'unchanged') {
		return $node;
	}});	

    $result = array_map(function ($node) use ($depth, $array, $parent) {

	$sFullPath = "Property '{$parent}{$node['name']}'";    

        if ($node['type'] === 'removed') {
            return "${sFullPath} was removed. \n";

        } elseif ($node['type'] === 'add') {
            return "${sFullPath} was added with value: " . getFormattedValue($node['value'], $depth) . "\n";

        } elseif ($node['type'] === 'changed') {
            return "${sFullPath} updated. From " . getFormattedValue($node['oldValue'], $depth) . " to " .getFormattedValue($node['newValue'], $depth) . "\n";

        } elseif ($node['type'] === 'nested') {

            $result = array_map(function ($subNode) use ($node, $depth, $parent) {
                return plain($subNode , $depth + 5, $parent . $node['name'] . ".");
            }, $node['children']);

            return $result ;
        }
    }, $filteredArray);

    $resultFlatten = flattenAll($result);

    $resultString = implode($resultFlatten);
        
    return $resultString;
   
    
}

function getFormattedValue($value, $depth) {

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (!is_array($value)) {
        return $value;
    }

    return "[complex value]";
}
