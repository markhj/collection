<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class HasTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)->push(1, 2, 3, 4);

		$this->assertFalse($collection->has(5));
		$this->assertTrue($collection->has(2));
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

		$this->assertFalse($collection->has(5));
		$this->assertTrue($collection->has(2));
	}

	/**
	 * @test
	 * @return void
	 */
	public function testObject(): void
	{
		$a = new \StdClass;
		$a->id = 55;

		$b = new \StdClass;
		$b->id = 180;

		$collection = (new Collection)->push($a);

		$this->assertTrue($collection->has($a));
		$this->assertFalse($collection->has($b));
	}
}
