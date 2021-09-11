<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class CloneTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)->push(1, 2, 3);
		$clone = $collection->clone();

		// Add an extra item to ensure separation
		$collection->push(4);

		$this->assertCount(3, $clone);
		$this->assertCount(4, $collection);

		$this->assertEquals(
			[1, 2, 3, 4],
			$collection->all()
		);

		$this->assertEquals(
			[1, 2, 3],
			$clone->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associative(): void
	{
		$collection = (new AssociativeCollection)
			->set('a', 1)
			->set('b', 2)
			->set('c', 3);

		$clone = $collection->clone();

		// Add an extra item to ensure separation
		$collection->set('d', 4);

		$this->assertCount(3, $clone);
		$this->assertCount(4, $collection);

		$this->assertEquals(
			[
				'a' => 1,
				'b' => 2,
				'c' => 3,
				'd' => 4,
			],
			$collection->all()
		);

		$this->assertEquals(
			[
				'a' => 1,
				'b' => 2,
				'c' => 3,
			],
			$clone->all()
		);
	}
}
