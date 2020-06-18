<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\diff\genDiff;

class DiffTest extends TestCase
{
    public function testDiff()
    {
        $actual = genDiff('before.json', 'after.json');
	$expected = "host: hexlet.io
+ timeout: 20
- timeout: 50
- proxy: 123.234.53.22
+ verbose: 1
";
        $this->assertEquals($expected, $actual);
    }
}
