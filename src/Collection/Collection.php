<?php

namespace Markhj\Collection;

use Markhj\Collection\Exceptions\IsAssociativeModeException;
use Markhj\Collection\Exceptions\NotAssociativeModeException;
use Markhj\Collection\Exceptions\KeyDoesNotExistException;
use Markhj\Collection\Exceptions\ValueDoesNotExistException;
use Markhj\Collection\Exceptions\InvalidItemTypeException;
use \Iterator;

class Collection implements Iterator
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
	 * Iterator position
	 * 
	 * @var int
	 */
	protected $cursor = 0;

	/**
	 * Type-cast to string (JSON)
	 * 
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->toJson();
	}

	/**
	 * Rewind the iterator cursor
	 * 
	 * @return void
	 */
	public function rewind()
	{
		$this->cursor = 0;
	}

	/**
	 * Current iterator value
	 * 
	 * @return mixed
	 */
	public function current()
	{
		return $this->get(
			$this->keys()->get($this->cursor)
		);
	}

	/**
	 * Iterator, next element
	 * 
	 * @return void
	 */
	public function next()
	{
		$this->cursor++;
	}

	/**
	 * Key iterator key
	 * 
	 * @return void
	 */
	public function key()
	{
		return $this->keys()->all()[$this->cursor] ?? null;
	}

	/**
	 * Iterator, has value at position
	 * 
	 * @return void
	 */
	public function valid()
	{
		return isset($this->collection[$this->key()]);
	}

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
			$this->validateAdd($object);

			$this->collection[] = $object;
		}

		return $this;
	}

	/**
	 * Get the index of the item
	 *
	 * Returns null, if not found (and graceful is enabled)
	 * If not graceful and nothing found, ValueDoesNotExistException
	 * 	will be thrown
	 * 	
	 * If multiple instances of same element, return first found
	 *
	 * For associative collections:
	 * This will not return the key, but the numeric index - similar
	 * to as if it was array
	 * 
	 * @param mixed $item
	 * @throws ValueDoesNotExistException
	 * @return null|int
	 */
	public function indexOf($item): ?int
	{
		foreach (array_values($this->collection) as $i => $row) {
			if ($row === $item) {
				return $i;
			}
		}

		if (!$this->isGraceful()) {
			throw new ValueDoesNotExistException;
		}

		return null;
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
		$this->validateAdd($object);

		$this->collection[$key] = $object;

		return $this;
	}

	/**
	 * Validate if the $object can be added
	 * 
	 * @param mixed $object
	 * @throws InvalidItemTypeException
	 * @return void
	 */
	protected function validateAdd($object): void
	{
		if (!$this->validate($object)) {
			throw new InvalidItemTypeException;
		}
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

	/**
	 * Reverse the collection
	 * 
	 * @return Collection
	 */
	public function reverse(): Collection
	{
		$this->collection = array_reverse($this->collection);

		return $this;
	}

	/**
	 * Carry out a manipulation on every element of the collection
	 * 
	 * @param callable $handler
	 * @return Collection
	 */
	public function map(callable $handler): Collection
	{
		foreach ($this->collection as $i => &$item) {
			$item = $handler($item, $i);
		}

		return $this;
	}

	/**
	 * Filter elements according to the handler
	 * 
	 * @param callable $handler
	 * @return Collection
	 */
	public function filter(callable $handler): Collection
	{
		$result = [];

		foreach ($this->collection as $i => $item) {
			if (!$handler($item, $i)) {
				continue;
			}
			
			if ($this->isAssociative()) {
				$result[$i] = $item;
			} else {
				$result[] = $item;
			}
		}

		$this->collection = $result;

		return $this;
	}

	/**
	 * Carry out an action on every element of the collection
	 * 
	 * @param callable $handler
	 * @return Collection
	 */
	public function forEach(callable $handler): Collection
	{
		foreach ($this->collection as $i => &$item) {
			$handler($item, $i);
		}

		return $this;
	}

	/**
	 * Sort the collection according to the $handler
	 * 
	 * @param callable $handler
	 * @return Collection
	 */
	public function sort(callable $handler): Collection
	{
		if ($this->isAssociative()) {
			uasort($this->collection, $handler);
		} else {
			usort($this->collection, $handler);
		}

		return $this;
	}

	/**
	 * Retrieve a Collection containing the keys of the
	 * collection
	 * 
	 * @return Collection
	 */
	public function keys(): Collection
	{
		return (new Collection)->push(...array_keys($this->collection));
	}

	/**
	 * Convert the collection to JSON
	 * 
	 * @return string
	 */
	public function toJson(): string
	{
		return json_encode($this->collection);
	}

	/**
	 * Access the first element
	 *
	 * Returns null, if collection is empty
	 *
	 * @return mixed
	 */
	public function first()
	{
		if (!$this->count()) {
			return null;
		}

		return $this->collection[$this->keys()->all()[0]];
	}

	/**
	 * Access the last element
	 *
	 * Returns null, if collection is empty
	 *
	 * @return mixed
	 */
	public function last()
	{
		if (!$this->count()) {
			return null;
		}

		$keys = $this->keys()->all();

		return $this->collection[$keys[count($keys) - 1]];
	}

	/**
	 * Make a clone of the collection
	 * 
	 * @return Collection
	 */
	public function clone(): Collection
	{
		$className = get_class($this);
		if ($this->isAssociative()) {
			$collection = new $className;
			foreach ($this->collection as $key => $value) {
				$collection->set($key, $value);
			}
			return $collection;
		} else {
			return (new $className)->push(...$this->all());
		}
	}

	/**
	 * Retrieve elements according to the $filter parameter
	 * and put them in a cloned collection
	 * 
	 * @param callable $filter
	 * @return Collection
	 */
	public function retrieve(callable $filter): Collection
	{
		return $this->clone()->filter($filter);
	}

	/**
	 * Cap the maximum number of items
	 * 
	 * @param int $limit
	 * @return Collection
	 */
	public function limit(int $limit): Collection
	{
		$this->crop(0, $limit);

		return $this;
	}

	/**
	 * Cap the maximum number of items
	 * 
	 * @param int $start
	 * @param int $size
	 * @return Collection
	 */
	public function crop(int $start, int $size): Collection
	{
		$this->collection = array_slice($this->collection, $start, $size);

		return $this;
	}

	/**
	 * Returns true if the element is found in the collection
	 * 
	 * @param mixed $element
	 * @return bool
	 */
	public function has($element): bool
	{
		foreach ($this->collection as $item) {
			if ($item === $element) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Returns true if all of the elements are found in the
	 * collection
	 * 
	 * @param mixed $items
	 * @return bool
	 */
	public function hasAllOf(...$items): bool
	{
		$found = [];

		foreach ($items as $i => $item) {
			if (!$this->has($item)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Returns true if any of the elements are found in the
	 * collection
	 * 
	 * @param mixed $items
	 * @return bool
	 */
	public function hasAnyOf(...$items): bool
	{
		foreach ($items as $item) {
			if ($this->has($item)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Intended to be overridden
	 *
	 * This enables the developer to limit the type of items
	 * added to the collection
	 * 
	 * @param mixed $item
	 * @return bool
	 */
	public function validate($item): bool
	{
		return true;
	}
}
