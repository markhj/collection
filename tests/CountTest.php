<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class CountTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function emptyNonAssociative(): void
	{
		$this->assertEquals(0, (new Collection)->count());
	}

	/**
	 * @test
	 * @return void
	 */
	public function emptyAssociative(): void
	{
		$this->assertEquals(0, (new AssociativeCollection)->count());
	}

	/**
	 * @test
	 * @return void
	 */
	public function nonAssociative(): void
	{
		$this->assertEquals(
			3,
			(new Collection)
				->push(1, 2, 3)
				->count()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associative(): void
	{
		$this->assertEquals(
			2,
			(new AssociativeCollection)
				->set('a', 10)
				->set('b', 20)
				->count()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function where(): void
	{
		$this->assertEquals(
			2,
			(new Collection)
				->push(1, 2, 3, 4, 5)
				->count(function($value, $key) {
					return $value % 2 == 0;
				})
		);
	}
}
