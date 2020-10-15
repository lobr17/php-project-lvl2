<?php

namespace Tests\fixtures;

function getDataComparisonJsonPlain()
{

    return <<<DOC
Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' updated. From true to [complex value] 
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' updated. From 'too much' to 'so much' 
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' updated. From 'bas' to 'bars' 
Property 'group1.nest' updated. From [complex value] to 'str' 
Property 'group2' was removed
Property 'group3' was added with value: [complex value]

DOC;
}