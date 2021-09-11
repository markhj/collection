<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use Markhj\Collection\Exceptions\KeyDoesNotExistException;
use PHPUnit\Framework\TestCase;
use \ReflectionClass;

class GetTest extends TestCase
{
	/**
	 * Make a mock of the collection with gracefullness
	 * enabled
	 * 
	 * @param Collection $collection
	 * @return Collection
	 */
	protected function makeGraceful(
		Collection $collection
	): Collection
	{
    	return $collection->graceful();
	}

	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)
			->push('a', 'b', 'c');

		$this->assertEquals(
			'a',
			$collection->get(0)
		);

		$this->assertEquals(
			'c',
			$collection->get(2)
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
			->set('hello', 'world');

		$this->assertEquals(
			10,
			$collection->get('a')
		);

		$this->assertEquals(
			'world',
			$collection->get('hello')
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function nonAssociativeNotGraceful(): void
	{
		$this->expectException(KeyDoesNotExistException::class);

		(new Collection)
			->push(0, 1, 2)
			->get(10);
	}

	/**
	 * @test
	 * @return void
	 */
	public function nonAssociativeGraceful(): void
	{
		$collection = $this->makeGraceful(new Collection);

    	$this->assertNull(
    		$collection
				->push(0, 1, 2)
				->get(10)
    	);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associativeNotGraceful(): void
	{
		$this->expectException(KeyDoesNotExistException::class);

		(new AssociativeCollection)
			->set('a', 10)
			->set('b', 20)
			->get('c');
	}

	/**
	 * @test
	 * @return void
	 */
	public function associativeGraceful(): void
	{
		$collection = $this->makeGraceful(new AssociativeCollection);

    	$this->assertNull(
    		$collection
				->set('a', 10)
				->set('b', 20)
				->get('c')
    	);
	}
}
