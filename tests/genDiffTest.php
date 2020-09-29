<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

//use function Differ\Differ\diff\genDiff;

use function Differ\Differ\parsers\decoderJsonInPhp;
use function Differ\Differ\parsers;
use function Differ\Differ\diff\diffArray;
use function Differ\Differ\Render\render;
use function Differ\Differ\Render\converter;

class DiffTest1 extends TestCase
{
    public function testDiff()
    {
        // $actual = genDiff('before.json', 'after.json');

        [$array1, $array2] = decoderJsonInPhp('../workfiles/before.json', '../workfiles/after.json');
        $tree = diffArray($array1, $array2);
        $render = render($tree, 3);
        $actual = converter($render);

        $expected = <<<DOC
{
   common: {
        + follow: false
        setting1: Value 1
        - setting2: 200
        - setting3: true
        + setting3: {
                      key:  value 
           }
        + setting4: blah blah
        + setting5: {
                      key5:  value5 
           }
        setting6: {
             doge: {
                  - wow: too much
                  + wow: so much
             }
             key: value
             + ops: vops
        }
   }
   group1: {
        - baz: bas
        + baz: bars
        foo: bar
        - nest: {
                      key:  value 
           }
        + nest: str
   }
   - group2: {
            abc:  12345 
            deep:  {
                  id:  45 
         } 
      }
   + group3: {
            fee:  100500 
            deep:  {
                  id:  {
                        number:  45 
            } 
         } 
      }
}

DOC;
        $this->assertEquals($expected, $actual);
    }
}
