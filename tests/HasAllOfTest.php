<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class HasAllOfTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)->push(1, 2, 3, 4);

		$this->assertFalse($collection->hasAllOf(5));
		$this->assertTrue($collection->hasAllOf(2));
		$this->assertTrue($collection->hasAllOf(2, 3));
		$this->assertFalse($collection->hasAllOf(2, 5));
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

		$this->assertFalse($collection->hasAllOf(5));
		$this->assertTrue($collection->hasAllOf(2));
		$this->assertTrue($collection->hasAllOf(2, 3));
		$this->assertFalse($collection->hasAllOf(2, 5));
	}
}
