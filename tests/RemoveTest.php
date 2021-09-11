<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use Markhj\Collection\Exceptions\KeyDoesNotExistException;
use PHPUnit\Framework\TestCase;
use \ReflectionClass;

class RemoveTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$collection = (new Collection)->push(1, 2, 3, 4, 5, 6);

		$this->assertEquals(
			[1, 2, 4, 5, 6],
			$collection
				->remove(2)
				->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function keyDoesNotExist(): void
	{
		$this->expectException(KeyDoesNotExistException::class);

		(new Collection)->push(1, 2)->remove(3);
	}

	/**
	 * @test
	 * @return void
	 */
	public function gracefulKeyDoesNotExist(): void
	{
		$this->expectNotToPerformAssertions();

		(new Collection)->graceful()->push(1, 2)->remove(3);
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
			->set('c', 30);

		$this->assertEquals(
			[
				'c' => 30,
			],
			$collection
				->remove('a', 'b')
				->all()
		);
	}
}
