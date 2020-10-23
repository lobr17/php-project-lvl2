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
        $expected = getDataComparisonJson();

        $nameFileBefore = $this->creatNameFixtures('before.json');
        $nameFileAfter = $this->creatNameFixtures('after.json');
        $actual = compareFiles($nameFileBefore, $nameFileAfter, 'pretty');

        $this->assertEquals($expected, $actual);
    }

    public function testDiffPlain()
    {
        $expected = getDataComparisonJsonPlain();

        $nameFileBefore = $this->creatNameFixtures('before.json');
        $nameFileAfter = $this->creatNameFixtures('after.json');
        $actual = compareFiles($nameFileBefore, $nameFileAfter, 'plain');

        $this->assertEquals($expected, $actual);
    }
}
