<?php

namespace Differ;

use PHPUnit\Framework\TestCase;
require_once "src/diff.php";

class diffTest extends TestCase
{
	public function testDiff()
	{
		$this->assertTrue(Differ\diff\genDiff('workfiles/before.php', 'workfiles/after.php'));
	}
}
