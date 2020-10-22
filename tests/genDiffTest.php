<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function Tests\fixtures\getDataComparisonJson;
use function Tests\fixtures\getDataComparisonJsonPlain;

use function Differ\Differ\Differ\compareFiles;

class DiffTest1 extends TestCase
{
    public function creatNameFixtures($nameFile)
    {
            return __DIR__ . "/fixtures/${nameFile}";
    }    
 
    public function testDiffPretty()
    {  
    	$this->creatNameFixtures($nameFile);

	$expected = getDataComparisonJson();

	$nameFileBefore = creatNameFixtures('before.json');
	$nameFileAfter = creatNameFixtures('after.json');
	$actual = compareFiles($nameFileBefore, $nameFileAfter, 'pretty');

	$this->assertEquals($expected, $actual);
    }

   /* public function testDiffPlain()
    {
        $actual = compareFiles(__DIR__ . '/fixtures/before.json', __DIR__ . '/fixtures/after.json', 'plain');

        $expected = getDataComparisonJsonPlain();

        $this->assertEquals($expected, $actual);
   }*/


}
