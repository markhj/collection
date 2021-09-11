<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class KeysTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)
			->push(1, 2, 3);

		$this->assertEquals(
			[0, 1, 2],
			$collection->keys()->all()
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
			->set('c', 30);

		$this->assertEquals(
			['a', 'b', 'c'],
			$collection->keys()->all()
		);
	}
}
