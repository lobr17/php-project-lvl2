<?php

/**
 * Преобразование полученного массива в читаемый вид.
 */

namespace Differ\Differ\Pretty;

use function Funct\Collection\flattenAll;

function iter($array, $depth)
{
    $tab = str_repeat(' ', $depth);
    $newTab = str_repeat(' ', $depth - 3);  

    $result = array_map(function ($node) use ($depth, $tab) {
    
        switch ($node['type']) {
            case 'removed':	  
	        return "${tab}- {$node['name']}: " . getFormattedValue($node['value'], $depth);
		break;

            case 'add':
		return "${tab}+ {$node['name']}: " . getFormattedValue($node['value'], $depth);    
		break;

	    case 'unchanged':
	        return "${tab}  {$node['name']}: " . getFormattedValue($node['value'], $depth);
	        break;

	    case 'changed':
                $removed = "${tab}- ${node['name']}: " . getFormattedValue($node['oldValue'], $depth) . "\n";
                $add = "${tab}" . "+ {$node['name']}: " . getFormattedValue($node['newValue'], $depth);
		return $removed . $add;
                break;

	    case 'nested':
                return "${tab} {$node['name']}: " . iter($node['children'], $depth + 4);
                break;
	}
    }, $array);

    $resultString = implode("\n", $result);
    return "{\n" . $resultString . "\n${newTab}}";

}

function getFormattedDiff($array)
{
    return iter($array, 3);  	    
}


function getFormattedValue($value, $depth)
{
        
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (!is_array($value)) {
        return $value;
    }
    
    $newDepth = $depth;
    $tab = str_repeat(' ', $depth);
    $newTab = str_repeat(' ', $newDepth + 4);

    $result = array_map(function ($key) use ($value, $newDepth, $tab, $newTab) {
        $formattedValue = getFormattedValue($value[$key], $newDepth + 4);
	  return "${newTab}{$key}: {$formattedValue}";
    }, array_keys($value));

       return "{\n" . implode("\n", $result) . "\n${tab}}";

}
