<?php

namespace Tests;

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use function Differ\Differ\diff\genDiff;

class diffTest extends TestCase
{
    public function testDiff()
    {
        $actual = genDiff('before.json', 'after.json');
        $expected =
"+ verbose:1
host: hexlet.io
+ timeout: 20
- timeout: 50
- proxy: 123.234.53.22
";
        $this->assertEquals($expected, $actual);
    }
}

