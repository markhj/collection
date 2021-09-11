<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class IterationTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$count = 0;
		$keys = [];
		$collection = (new Collection)->push(1, 2, 3);

		foreach ($collection as $i => $item) {
			$count++;

			$keys[] = $i;
		}

		$this->assertEquals(3, $count);
		$this->assertEquals([0, 1, 2], $keys);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associative(): void
	{
		$count = 0;
		$keys = [];
		$collection = (new AssociativeCollection)
			->set('a', 1)
			->set('b', 2)
			->set('c', 3);

		foreach ($collection as $i => $item) {
			$count++;

			$keys[] = $i;
		}

		$this->assertEquals(3, $count);
		$this->assertEquals(['a', 'b', 'c'], $keys);
	}
}
