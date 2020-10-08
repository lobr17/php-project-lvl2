<?php

namespace Differ\Differ\Plain;

use function Funct\Collection\flattenAll;
use function Funct\Collection\compact;

use Exception;

function iter($array, $depth, $parent)
{
    $result = array_map(function ($node) use ($depth, $array, $parent) {

        $sFullPath = "${parent}{$node['name']}";
        
        switch ($node['type']) {
	    case 'removed':
	        return "Property '${sFullPath}' was removed";
		break;

	    case 'add':
                return "Property '${sFullPath}' was added with value: " . getFormattedValue($node['value'], $depth);
                break;

	    case 'changed':
                $oldValue = "Property '${sFullPath}' updated. From " . getFormattedValue($node['oldValue'], $depth);
                $newValue = " to " . getFormattedValue($node['newValue'], $depth);
		return $oldValue . $newValue;
		break;

            case 'nested':
		    return iter($node['children'], $depth + 5, $sFullPath . ".");
		    break;

	    case 'unchanged': 
	        break;	    

	    default:
                Print_r("Error ${node['type']} \n");	
	}

    }, $array);

    $resultFlatten = compact(flattenAll($result));
  

    $resultString = implode("\n", $resultFlatten);
        
   
        return $resultString;
    
}

function plain($array)
{
    return iter($array, 3, $parent = null) . "\n";
}


function getFormattedValue($value, $depth)
{

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (!is_array($value)) {
        return "'${value}'";
    }

    return "[complex value]";
}
