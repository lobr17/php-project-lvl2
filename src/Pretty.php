<?php

/**
 * Преобразование полученного массива в читаемый вид.
 */

namespace Differ\Differ\Pretty;

use function Funct\Collection\flattenAll;

function iter($array, $depth)
{
    $tab = creatTab($depth);
    $closableTab = creatTab($depth - 2);  

    $result = array_map(function ($node) use ($depth, $tab) {
        switch ($node['type']) {
	case 'removed':	  
		$formattedValue = getFormattedValue($node['value'], $depth);
	        return "${tab}- {$node['name']}: $formattedValue";
		break;

	    case 'add':
		$formattedValue = getFormattedValue($node['value'], $depth);
		return "${tab}+ {$node['name']}: $formattedValue";    
		break;

	    case 'unchanged':
		$formattedValue = getFormattedValue($node['value'], $depth);
		return "${tab}  {$node['name']}: $formattedValue";
	        break;

	    case 'changed':
		$formattedOldValue = getFormattedValue($node['oldValue'], $depth);
                $formattedNewValue = getFormattedValue($node['newValue'], $depth);    
		$removed = "${tab}- ${node['name']}: $formattedOldValue \n";
                $add = "${tab}" . "+ {$node['name']}: $formattedNewValue";
		return $removed . $add;
                break;

	    case 'nested':
                return " ${tab} {$node['name']}: " . iter($node['children'], $depth + 4);
                break;
	}
    }, $array);

    $resultString = implode("\n", $result);
    return "{\n" . $resultString . "\n${closableTab}}";

}

function creatTab($depth)
{
    return str_repeat(' ', $depth);    
}

function getFormattedDiff($array)
{
    return iter($array, 2);  	    
}


function getFormattedValue($value, $depth)
{
        
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (!is_array($value)) {
        return $value;
    }

    $tab = creatTab($depth);
    $newTab = creatTab($depth + 4);
    $closableTab = creatTab($depth);

    $result = array_map(function ($key) use ($value, $depth, $tab, $newTab, $closableTab) {
        $formattedValue = getFormattedValue($value[$key], $depth + 4);
	  return "${newTab}{$key}: {$formattedValue}";
    }, array_keys($value));

    return "{\n" . implode("\n", $result) . "\n${closableTab}}";

}
