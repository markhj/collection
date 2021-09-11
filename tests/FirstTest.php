<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$this->assertEquals(
			1,
			(new Collection)
				->push(1, 2, 3)
				->first()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associative(): void
	{
		$this->assertEquals(
			10,
			(new AssociativeCollection)
				->set('a', 10)
				->set('b', 20)
				->set('c', 30)
				->first()
		);
	}
}
