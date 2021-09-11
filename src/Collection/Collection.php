<?php

namespace Markhj\Collection;

use Markhj\Collection\Exceptions\IsAssociativeModeException;
use Markhj\Collection\Exceptions\NotAssociativeModeException;
use Markhj\Collection\Exceptions\KeyDoesNotExistException;

class Collection
{
	/**
	 * Internal container of objects
	 * 
	 * @var array
	 */
	protected $collection = [];

	/**
	 * Can be set to true for child classes looking
	 * to utilize associative keys
	 * 
	 * @var bool
	 */
	protected $associative = false;

	/**
	 * When false exceptions will be thrown when an index
	 * doesn't exist
	 *
	 * Set to true, if you want to handle this gracefully -
	 * typically meaning null will be returned instead, or
	 * that no actions will be taken
	 * 
	 * @var bool
	 */
	protected $graceful = false;

	/**
	 * Returns true if the collection instance is 
	 * in associative mode
	 * 
	 * @return bool
	 */
	protected function isAssociative(): bool
	{
		return $this->associative;
	}

	/**
	 * Returns true if the collection is to handle missing
	 * indices gracefully
	 * 
	 * @return bool
	 */
	protected function isGraceful(): bool
	{
		return $this->graceful;
	}

	/**
	 * Helper method to ensure the collection is associative
	 *
	 * @throws NotAssociativeModeException
	 * @return void
	 */
	protected function requireAssociativeMode(): void
	{
		if (!$this->isAssociative()) {
			throw new NotAssociativeModeException;
		}
	}

	/**
	 * Helper method to ensure the collection is not associative
	 *
	 * @throws IsAssociativeModeException
	 * @return void
	 */
	protected function requireNonAssociativeMode(): void
	{
		if ($this->isAssociative()) {
			throw new IsAssociativeModeException;
		}
	}

	/**
	 * Push one or more objects to the collection array
	 * 
	 * @param mixed $objects
	 * @return Collection
	 */
	public function push(...$objects): Collection
	{
		$this->requireNonAssociativeMode();

		foreach ($objects as $object) {
			$this->collection[] = $object;
		}

		return $this;
	}

	/**
	 * To be used in associative mode
	 * 
	 * @param mixed $key
	 * @param mixed $object
	 * @return Collection
	 */
	public function set($key, $object): Collection
	{
		$this->requireAssociativeMode();

		$this->collection[$key] = $object;

		return $this;
	}

	/**
	 * Retrieve the element at $key
	 * 
	 * @param mixed $key
	 * @return mixed
	 */
	public function get($key)
	{
		if (
			!$this->isGraceful()
			&& !isset($this->collection[$key])
		) {
			throw new KeyDoesNotExistException;
		}

		return $this->collection[$key] ?? null;
	}

	/**
	 * Return all contained objects as an array
	 * 
	 * @return array
	 */
	public function all(): array
	{
		return $this->collection;
	}

	/**
	 * Count the number of elements in the collection
	 * 
	 * @return int
	 */
	public function count(): int
	{
		return count($this->collection);
	}
}
