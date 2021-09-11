<?php

namespace Markhj\Collection;

use Markhj\Collection\Exceptions\IsAssociativeModeException;
use Markhj\Collection\Exceptions\NotAssociativeModeException;

class AssociativeCollection extends Collection
{
	/**
	 * Associative mode for collection
	 * 
	 * @var bool
	 */
	protected $associative = true;
}