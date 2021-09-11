<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class AssociativeCollectionTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new AssociativeCollection)
			->set('a', 10)
			->set('b', 20);

		$this->assertEquals(
			[
				'a' => 10,
				'b' => 20,
			],
			$collection->all()
		);
	}
}
