<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use Markhj\Collection\Exceptions\IsAssociativeModeException;
use PHPUnit\Framework\TestCase;

class PrependTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function basic(): void
	{
		$a = (new Collection)->push(1, 2, 3);
		$b = (new Collection)->push(1, 8);

		$this->assertEquals(
			[1, 8, 1, 2, 3],
			$a->prepend($b)->all()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function associative(): void
	{
		$this->expectException(IsAssociativeModeException::class);

		(new AssociativeCollection)->append(new AssociativeCollection);
	}
}
