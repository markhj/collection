<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class AddTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)->push(1, 2, 3);

		$this->assertEquals(
			[1, 2, 3, 4, 5],
			$collection->add((new Collection)->push(4, 5))->all()
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
			->set('b', 2);

		$b = (new AssociativeCollection)
			->set('b', 5)
			->set('c', 3);

		$this->assertEquals(
			[
				'a' => 1,
				'b' => 5,
				'c' => 3,
			],
			$collection->add($b)->all()
		);
	}
}
