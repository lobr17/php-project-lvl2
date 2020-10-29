<?php

namespace Tests\fixtures;

function getDataComparisonJson()
{

    return <<<DOC
{"0":{"name":"common","type":"nested","children":{"4":{"name":"follow","type":"add","value":false},"0":{"name":"setting1","type":"unchanged","value":"Value 1"},"1":{"name":"setting2","type":"removed","value":200},"2":{"name":"setting3","type":"changed","oldValue":true,"newValue":{"key":"value"}},"7":{"name":"setting4","type":"add","value":"blah blah"},"8":{"name":"setting5","type":"add","value":{"key5":"value5"}},"3":{"name":"setting6","type":"nested","children":{"1":{"name":"doge","type":"nested","children":[{"name":"wow","type":"changed","oldValue":"too much","newValue":"so much"}]},"0":{"name":"key","type":"unchanged","value":"value"},"3":{"name":"ops","type":"add","value":"vops"}}}}},"1":{"name":"group1","type":"nested","children":[{"name":"baz","type":"changed","oldValue":"bas","newValue":"bars"},{"name":"foo","type":"unchanged","value":"bar"},{"name":"nest","type":"changed","oldValue":{"key":"value"},"newValue":"str"}]},"2":{"name":"group2","type":"removed","value":{"abc":12345,"deep":{"id":45}}},"5":{"name":"group3","type":"add","value":{"fee":100500,"deep":{"id":{"number":45}}}}}
DOC;
}
