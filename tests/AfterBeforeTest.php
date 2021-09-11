<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use Markhj\Collection\Exceptions\AssociativeModeMismatchException;
use Markhj\Collection\Exceptions\KeyDoesNotExistException;
use Markhj\Collection\Exceptions\OverlappingKeysException;
use PHPUnit\Framework\TestCase;

class AfterBeforeTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basicAfter(): void
	{
		$collection = (new Collection)->push(1, 2, 3, 4);
		$other = (new Collection)->push(10, 20);

		$this->assertEquals(
			[1, 2, 3, 10, 20, 4],
			$collection
				->after(2, $other)
				->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function basicBefore(): void
	{
		$collection = (new Collection)->push(1, 2, 3, 4);
		$other = (new Collection)->push(10, 20);

		$this->assertEquals(
			[1, 2, 10, 20, 3, 4],
			$collection
				->before(2, $other)
				->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function typeMismatchCaseA(): void
	{
		$this->expectException(AssociativeModeMismatchException::class);

		(new Collection)->before(0, new AssociativeCollection);
	}

	/**
	 * @test
	 * @return void
	 */
	public function typeMismatchCaseB(): void
	{
		$this->expectException(AssociativeModeMismatchException::class);

		(new AssociativeCollection)->before(0, new Collection);
	}

	/**
	 * @test
	 * @return void
	 */
	public function keyDoesNotExist(): void
	{
		$this->expectException(KeyDoesNotExistException::class);

		(new Collection)->before(0, new Collection);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associativeAfter(): void
	{
		$collection = (new AssociativeCollection)
			->set('a', 1)
			->set('b', 2)
			->set('c', 3);

		$other = (new AssociativeCollection)
			->set('x', 10)
			->set('p', 50);

		$this->assertEquals(
			[
				'a' => 1,
				'b' => 2,
				'x' => 10,
				'p' => 50,
				'c' => 3,
			],
			$collection
				->after('b', $other)
				->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associativeBefore(): void
	{
		$collection = (new AssociativeCollection)
			->set('a', 1)
			->set('b', 2)
			->set('c', 3);

		$other = (new AssociativeCollection)
			->set('x', 10)
			->set('p', 50);

		$this->assertEquals(
			[
				'a' => 1,
				'x' => 10,
				'p' => 50,
				'b' => 2,
				'c' => 3,
			],
			$collection
				->before('b', $other)
				->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associativeOverlappingKeys(): void
	{
		$this->expectException(OverlappingKeysException::class);

		$collection = (new AssociativeCollection)
			->set('a', 1)
			->set('b', 2)
			->set('c', 3);

		$other = (new AssociativeCollection)
			->set('b', 10)
			->set('p', 50);

		$collection->before('b', $other);
	}
}
