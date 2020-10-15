<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\Parsers\getArrayForTree;
use function Differ\Differ\TreeBuilder\getTree;
use function Differ\Differ\Render\getFormattedDiff;
use function Differ\Differ\formatters\Plain\plain;
use function Differ\Differ\FormatRequest\getFormatRequest;
use function Tests\fixtures\getDataComparisonJson;
use function Tests\fixtures\getDataComparisonJsonPlain;

class DiffTest1 extends TestCase
{
    public function testDiff()
    {
        $array1 = json_decode(file_get_contents(__DIR__ . '/fixtures/before.json'), true);
        $array2 = json_decode(file_get_contents(__DIR__ . '/fixtures/after.json'), true);

        $tree = getTree($array1, $array2);

        $actual = getFormatRequest('pretty', $tree);

        $expected = getDataComparisonJson();

        $this->assertEquals($expected, $actual);
    }

    public function testDiffPlain()
    {
        $array1 = json_decode(file_get_contents(__DIR__ . '/fixtures/before.json'), true);
        $array2 = json_decode(file_get_contents(__DIR__ . '/fixtures/after.json'), true);

        $tree = getTree($array1, $array2);

        $actual = getFormatRequest('plain', $tree);

        $expected = getDataComparisonJsonPlain();

        $this->assertEquals($expected, $actual);
    }
}
