<?php

namespace Differ\Differ\Plain;

use function Funct\Collection\flattenAll;

function iter($array, $depth, $parent)
{
    $result = array_map(function ($node) use ($depth, $array, $parent) {

        $sFullPath = "Property '{$parent}{$node['name']}'";
        
        switch ($node['type']) {
	    case 'removed':
	        return "${sFullPath} was removed.";
		break;

	    case 'add':
                return "${sFullPath} was added with value: '" . getFormattedValue($node['value'], $depth);
                break;

	    case 'changed':
                $oldValue = "${sFullPath} updated. From '" . getFormattedValue($node['oldValue'], $depth);
                $newValue = "' to '" . getFormattedValue($node['newValue'], $depth);
		return $oldValue . $newValue;
		break;

            case 'nested':
                return iter($node['children'], $depth + 5, $parent . $node['name'] . ".");
		break;

	    default:
                print_r("Error \n");	
	}

    }, $array);

    $resultFlatten = flattenAll($result);

    $resultString = implode("\n", $resultFlatten);
        
    return $resultString;
}

function plain($array)
{
    return iter($array, 3, $parent = null);
}


function getFormattedValue($value, $depth)
{

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (!is_array($value)) {
        return $value;
    }

    return "[complex value]";
}
