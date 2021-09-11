<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use PHPUnit\Framework\TestCase;

class RetrieveTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)->push(1, 2, 3);
		
		$this->assertEquals(
			[1, 3],
			$collection->retrieve(function($item) {
				return $item != 2;
			})->all()
		);
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
			->set('c', 3);
		
		$this->assertEquals(
			[
				'a' => 1,
				'c' => 3,
			],
			$collection->retrieve(function($item) {
				return $item != 2;
			})->all()
		);
	}
}
