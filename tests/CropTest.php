<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class CropTest extends TestCase
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
			$collection->clone()->crop(0, 2)->all()
		);

		$this->assertEquals(
			[2, 3],
			$collection->clone()->crop(1, 2)->all()
		);

		$this->assertEquals(
			[3, 4],
			$collection->clone()->crop(2, 5)->all()
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
			[1, 2],
			array_values($collection->clone()->crop(0, 2)->all())
		);

		$this->assertEquals(
			[2, 3],
			array_values($collection->clone()->crop(1, 2)->all())
		);

		$this->assertEquals(
			[3, 4],
			array_values($collection->clone()->crop(2, 5)->all())
		);
	}
}
