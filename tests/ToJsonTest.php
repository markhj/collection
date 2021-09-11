<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class ToJsonTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)->push(1, 2, 3);

		$this->assertEquals(
			json_encode([1, 2, 3]),
			$collection->toJson()
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
			->set('b', 20);

		$this->assertEquals(
			json_encode([
				'a' => 10,
				'b' => 20,
			]),
			$collection->toJson()
		);
	}
}
