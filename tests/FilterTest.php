<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)
			->push(1, 2, 3)
			->filter(function($item) {
				return $item % 2 != 0;
			});

		$this->assertEquals(
			[1, 3],
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
			->set('c', 30)
			->filter(function($item, $key) {
				return $key != 'b';
			});

		$this->assertEquals(
			[
				'a' => 10,
				'c' => 30,
			],
			$collection->all()
		);
	}
}
