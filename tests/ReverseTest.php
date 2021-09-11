<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class ReverseTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)
			->push(1, 2, 3)
			->reverse();

		$this->assertEquals(
			[3, 2, 1],
			$collection->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associative(): void
	{
		$collection = (new AssociativeCollection)
			->set('a', 10)
			->set('b', 20)
			->reverse();

		$this->assertEquals(
			[
				'b' => 20,
				'a' => 10,
			],
			$collection->all()
		);
	}
}
