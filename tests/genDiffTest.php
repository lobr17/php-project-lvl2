<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\Parsers\getArrayForTree;
use function Differ\Differ\Diff\getDiff;
use function Differ\Differ\Render\addOuterBreckets;
use function Differ\Differ\Render\getFormattedDiff;
use function Differ\Differ\formatters\Plain\plain;
use function Differ\Differ\Differ\getFormatRequest;

class DiffTest1 extends TestCase
{
    public function testDiff()
    {
        $array1 = json_decode(file_get_contents(__DIR__ . '/fixtures/before.json'), true);
        $array2 = json_decode(file_get_contents(__DIR__ . '/fixtures/after.json'), true);

        $tree = getDiff($array1, $array2);

        $actual = getFormatRequest('pretty', $tree);

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
