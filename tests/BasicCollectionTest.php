<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use PHPUnit\Framework\TestCase;

class BasicCollectionTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = new Collection;

		$collection->push(2, 5, 7);

		$this->assertEquals(
			[2, 5, 7],
			$collection->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function multipleAdds(): void
	{
		$collection = new Collection;

		$collection->push(2);
		$collection->push(5);
		$collection->push(7);

		$this->assertEquals(
			[2, 5, 7],
			$collection->all()
		);
	}
}
