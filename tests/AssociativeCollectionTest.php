<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\AssociativeCollection;
use Markhj\Collection\Exceptions\InvalidItemTypeException;
use PHPUnit\Framework\TestCase;
use \ReflectionClass;

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

	/**
	 * @test
	 * @return void
	 */
	public function invalidType(): void
	{
		$this->expectException(InvalidItemTypeException::class);

		$collection = $this->getMockBuilder(AssociativeCollection::class)
			->onlyMethods(['validate'])
			->getMock();

		$collection->method('validate')->willReturn(false);
		
    	$collection->set(0, null);
	}
}
