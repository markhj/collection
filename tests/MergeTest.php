<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use Markhj\Collection\Exceptions\AssociativeModeMismatchException;
use PHPUnit\Framework\TestCase;

class MergeTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$a = (new Collection)->push(1, 2);
		$b = (new Collection)->push(1, 20);

		$a->merge($b);

		$this->assertEquals(
			[1, 20],
			$a->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associative(): void
	{
		$a = (new AssociativeCollection)
			->set('a', 1)
			->set('b', 2);

		$b = (new AssociativeCollection)
			->set('a', 3)
			->set('c', 20);

		$a->merge($b);

		$this->assertEquals(
			[
				'a' => 3,
				'b' => 2,
				'c' => 20,
			],
			$a->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function mergePreserving(): void
	{
		$a = (new Collection)->push(1, 2);
		$b = (new Collection)->push(1, 20);

		$a->mergePreserving($b);

		$this->assertEquals(
			[1, 2],
			$a->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function mergePreservingAssociative(): void
	{
		$a = (new AssociativeCollection)
			->set('a', 1)
			->set('b', 2);

		$b = (new AssociativeCollection)
			->set('a', 3)
			->set('c', 20);

		$a->mergePreserving($b);

		$this->assertEquals(
			[
				'a' => 1,
				'b' => 2,
				'c' => 20,
			],
			$a->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function modeMismatchCaseA(): void
	{
		$this->expectException(AssociativeModeMismatchException::class);

		(new Collection)->merge(new AssociativeCollection);
	}

	/**
	 * @test
	 * @return void
	 */
	public function modeMismatchCaseB(): void
	{
		$this->expectException(AssociativeModeMismatchException::class);

		(new AssociativeCollection)->merge(new Collection);
	}
}
