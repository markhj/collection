<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class SortTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)
			->push(8, 2, 5)
			->sort(function($a, $b) {
				return $a > $b;
			});

		$this->assertEquals(
			[2, 5, 8],
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
			->set('a', 80)
			->set('b', 20)
			->set('c', 50)
			->sort(function($a, $b) {
				return $a > $b;
			});

		$this->assertEquals(
			[
				'b' => 20,
				'c' => 50,
				'a' => 80,
			],
			$collection->all()
		);
	}
}
