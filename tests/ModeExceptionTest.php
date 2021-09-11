<?php

namespace Markhj\Collection\Tests;

use Markhj\Collection\Collection;
use Markhj\Collection\AssociativeCollection;
use Markhj\Collection\Exceptions\IsAssociativeModeException;
use Markhj\Collection\Exceptions\NotAssociativeModeException;
use PHPUnit\Framework\TestCase;

class ModeExceptionTest extends TestCase
{
	/**
	 * @test
	 * @return void
	 */
	public function setNotAssociative(): void
	{
		$this->expectException(NotAssociativeModeException::class);

		(new Collection)->set(0, null);
	}

	/**
	 * @test
	 * @return void
	 */
	public function pushWhenAssociative(): void
	{
		$this->expectException(IsAssociativeModeException::class);

		(new AssociativeCollection)->push(0);
	}
}
