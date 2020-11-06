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
        $fullFileName = $this->addPath('testJsonPretty');	
	$getDirtyFile = file_get_contents($fullFileName);
        $expected = trim($getDirtyFile);	

        $pathFileBefore = $this->addPath('before.json');
        $pathFileAfter = $this->addPath('after.json');
        $actual = compareFiles($pathFileBefore, $pathFileAfter, 'pretty');

        $this->assertEquals($expected, $actual);
    }

    public function testDiffPlain()
    {
        $fullFileName = $this->addPath('testJsonPlain');
        $getDirtyFile = file_get_contents($fullFileName);
        $expected = $getDirtyFile;

        $pathFileBefore = $this->addPath('before.json');
        $pathFileAfter = $this->addPath('after.yml');
        $actual = compareFiles($pathFileBefore, $pathFileAfter, 'plain');

        $this->assertEquals($expected, $actual);
    }

    public function testDiffJson()
    {
        $fullFileName = $this->addPath('testJson');
        $getDirtyFile = file_get_contents($fullFileName);
        $expected = trim($getDirtyFile);

        $pathFileBefore = $this->addPath('before.json');
        $pathFileAfter = $this->addPath('after.json');
        $actual = compareFiles($pathFileBefore, $pathFileAfter, 'json');

        $this->assertEquals($expected, $actual);
    }
}
