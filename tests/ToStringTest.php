<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class ToStringTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$this->assertEquals(
			json_encode([1, 2, 3]),
			(string) (new Collection)->push(1, 2, 3)
		);
	}
}
