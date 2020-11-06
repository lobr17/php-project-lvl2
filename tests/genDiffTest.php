<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\compareFiles;

class DiffTest1 extends TestCase
{
    public function addPath($fileName)
    {
        return __DIR__ . "/fixtures/${fileName}";
    }

    public function testDiffPretty()
    {
        $fileName = __DIR__ . "/fixtures/testJsonPretty";	
	$getDirtyFile = file_get_contents($fileName);
        $expected = trim($getDirtyFile);	

        $pathFileBefore = $this->addPath('before.json');
        $pathFileAfter = $this->addPath('after.json');
        $actual = compareFiles($pathFileBefore, $pathFileAfter, 'pretty');

        $this->assertEquals($expected, $actual);
    }

    public function testDiffPlain()
    {
        $fileName = __DIR__ . "/fixtures/testJsonPlain";
        $getDirtyFile = file_get_contents($fileName);
        $expected = $getDirtyFile;

        $pathFileBefore = $this->addPath('before.json');
        $pathFileAfter = $this->addPath('after.yml');
        $actual = compareFiles($pathFileBefore, $pathFileAfter, 'plain');

        $this->assertEquals($expected, $actual);
    }

    public function testDiffJson()
    {
        $fileName = __DIR__ . "/fixtures/testJson";
        $getDirtyFile = file_get_contents($fileName);
        $expected = trim($getDirtyFile);

        $pathFileBefore = $this->addPath('before.json');
        $pathFileAfter = $this->addPath('after.json');
        $actual = compareFiles($pathFileBefore, $pathFileAfter, 'json');

        $this->assertEquals($expected, $actual);
    }
}
