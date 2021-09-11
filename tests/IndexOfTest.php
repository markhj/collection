<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use Markhj\Collection\Exceptions\ValueDoesNotExistException;
use PHPUnit\Framework\TestCase;
use \ReflectionClass;

class IndexOfTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)->push(10, 20, 30, 20);

		$this->assertEquals(
			2,
			$collection->indexOf(30)
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
			->set('c', 30)
			->set('d', 20);

		$this->assertEquals(
			2,
			$collection->indexOf(30)
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function notFoundGraceful(): void
	{
		$collection = (new Collection)->push(10, 20, 30, 20);

		$collection = $this->getMockBuilder(get_class($collection))
        	->disableOriginalConstructor()
        	->getMock();

    	$reflection = new ReflectionClass(Collection::class);
    	$graceful = $reflection->getProperty('graceful');
    	$graceful->setAccessible(true);
    	$graceful->setValue($collection, true);

		$this->assertNull($collection->indexOf(5));
	}

	/**
	 * @test
	 * @return void
	 */
	public function notFoundNotGraceful(): void
	{
		$this->expectException(ValueDoesNotExistException::class);

		(new Collection)
			->push(10, 20, 30, 20)
			->indexOf(50);
	}
}
