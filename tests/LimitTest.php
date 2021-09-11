<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class LimitTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)->push(1, 2, 3, 4);

		$this->assertEquals(
			[1, 2],
			$collection->clone()->limit(2)->all()
		);

		$this->assertEquals(
			[1, 2, 3, 4],
			$collection->clone()->limit(10)->all()
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
			->set('c', 3)
			->set('d', 4);

		$this->assertEquals(
			[
				'a' => 1,
				'b' => 2,
			],
			$collection->clone()->limit(2)->all()
		);

		$this->assertEquals(
			[
				'a' => 1,
				'b' => 2,
				'c' => 3,
				'd' => 4,
			],
			$collection->clone()->limit(10)->all()
		);
	}
}
