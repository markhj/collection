<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class ForEachTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)
			->push(1, 2, 3)
			->forEach(function($item) {
				return $item * 2;
			});

		$this->assertEquals(
			[2, 4, 6],
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
			->forEach(function($item) {
				return $item * 2;
			});

		$this->assertEquals(
			[
				'b' => 40,
				'a' => 20,
			],
			$collection->all()
		);
	}
}
