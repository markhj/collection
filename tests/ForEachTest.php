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
		$sum = 0;
		$collection = (new Collection)
			->push(1, 2, 3)
			->forEach(function($item) use(&$sum) {
				return $sum += $item;
			});

		$this->assertEquals(6, $sum);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associative(): void
	{
		$sum = 0;
		$collection = (new AssociativeCollection)
			->set('a', 10)
			->set('b', 20)
			->forEach(function($item) use(&$sum) {
				return $sum += $item;
			});

		$this->assertEquals(30, $sum);
	}
}
