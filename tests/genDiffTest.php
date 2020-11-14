<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\compareFiles;

class DiffTest1 extends TestCase
{
    public function getFixtureFullPath($fileName)
    {
        return __DIR__ . "/fixtures/${fileName}";
    }

    public function testDiffPretty()
    {
        $filePath = $this->getFixtureFullPath('testJsonPretty');
        $dirtyFile = file_get_contents($filePath);
        $expected = trim($dirtyFile);

        $fileBeforePath = $this->getFixtureFullPath('before.json');
        $fileAfterPath = $this->getFixtureFullPath('after.json');
        $actual = compareFiles($fileBeforePath, $fileAfterPath, 'pretty');

        $this->assertEquals($expected, $actual);
    }

    public function testDiffPlain()
    {
        $filePath = $this->getFixtureFullPath('testJsonPlain');
        $dirtyFile = file_get_contents($filePath);
        $expected = $dirtyFile;

        $fileBeforePath = $this->getFixtureFullPath('before.json');
        $fileAfterPath = $this->getFixtureFullPath('after.yml');
        $actual = compareFiles($fileBeforePath, $fileAfterPath, 'plain');

        $this->assertEquals($expected, $actual);
    }

    public function testDiffJson()
    {
        $filePath = $this->getFixtureFullPath('testJson');
        $dirtyFile = file_get_contents($filePath);
        $expected = trim($dirtyFile);

        $fileBeforePath = $this->getFixtureFullPath('before.json');
        $fileAfterPath = $this->getFixtureFullPath('after.json');
        $actual = compareFiles($fileBeforePath, $fileAfterPath, 'json');

        $this->assertEquals($expected, $actual);
 }

/*    public function testDiffJson()
    {
        $filePath = $this->getFixtureFullPath('testJson');
        $dirtyFile = file_get_contents($filePath);
        $expected = trim($dirtyFile);

        $fileBeforePath = $this->getFixtureFullPath('before.json');
        $fileAfterPath = $this->getFixtureFullPath('after.json');
        $actual = compareFiles($fileBeforePath, $fileAfterPath, 'json');

        $this->assertStringEqualsFile($filePath, $actual);
}*/
}
