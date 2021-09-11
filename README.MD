This Collection library is best thought of as an "upgraded object-oriented array".

This package provides features to write more beautiful and readable code.

# Install
You can install this package to your PHP project with:
```
composer require markhj/collection
```
You will need Composer 2.

# Example
```php
use Markhj\Collection\Collection;

$collection = new Collection;
$collection->push('John', 'Jane');

$collection->map(function($item) {
	return $item . ' Doe';
});

var_dump($collection->all()); // John Doe, Jane Doe
```

# Basic methods
```php
public function push(...$objects): Collection;
public function set($key, $object): Collection;
public function get($key);
public function all(): array;
public function count(): int;
public function reverse(): Collection;
public function keys(): Collection;
public function toJson(): string;
public function indexOf($item): ?int;
public function clone(): Collection;
public function crop(int $start, int $size): Collection;
public function limit(int $limit): Collection;
public function has($item): bool;
public function hasAllOf(...$items): bool;
public function hasAnyOf(...$items): bool;
```

# Language features
## Typecasting
When you typecast the collection to string, it will return the JSON structure of the collection.

## Iteration
You can use the ````foreach```` operator on the collection instance.
```php
foreach ($collection as $key => $value) {
	// ...
}
```

# Example use of other methods
## map
The map method iterates over every element of the collection, and assigns the returned value of the handler to the element in the collection.
````php
$collection = (new Collection)
	->push(1, 2, 3)
	->map(function($item, $key) {
		return $item * 2;
	});

// 2, 4, 6
````
## forEach
The forEach method is in many ways similar to the map method, but it will not assign the returned value to the element in the collection.
Instead you can carry out actions which aren't directly related to the collection itself.
````php
$sum = 0;
$collection = (new Collection)
	->push(1, 2, 3)
	->forEach(function($item, $key) use(&$sum) {
		return $sum += $item;
	});

// $sum is 6
````
## sort
The ````sort```` method sorts the collection elements by a defined handler (callable)
````php
$collection = (new Collection)
	->push(8, 2, 5)
	->sort(function($a, $b) {
		return $a > $b;
	});

// 2, 5, 8
````
## filter
The ````filter```` method removes unwanted elements from the collection.
````php
$collection = (new Collection)
	->push(8, 2, 5)
	->filter(function($a) {
		return $a != 2;
	});

// 8, 5
````
## retrieve
The ````retrieve```` method creates a new (cloned) collection based on requested elements.
This allows you to extract a filtered subset of elements, without affecting the original collection itself.
````php
$evenNumbers = $collection->retrieve(function($a) {
	return $a % 2 == 0;
});
````
## has
The ````has```` method returns true if the target item is found in the collection.
````php
$collection = (new Collection)->push(1, 2, 3);
$collection->has(1); // true
$collection->has(8); // false
````
The ````has```` method can also compare objects.

## hasAnyOf
````php
$collection = (new Collection)->push(1, 2, 3);
$collection->hasAnyOf(2, 8); // true
$collection->hasAnyOf(8, 11); // false
````

## hasAllOf
````php
$collection = (new Collection)->push(1, 2, 3);
$collection->hasAllOf(2, 3); // true
$collection->hasAllOf(2, 8); // false
````

# Inheritance
You can use the "out of the box" collection objects provied in the package, but in many instances it makes sense to write custom collections which inherit the Collection. This allows you to expand with relevant methods.

For example, you can create a collection of date/time objects, where you add methods to retrieve the earliest and latest instances.

```php
class MyCustomDateCollection extends Collection
{
	public function earliest()
	{
		// ...
	}

	public function latest()
	{
		// ...
	}
}
```

Another example would be a collection of payment methods, where you add methods relevant to your business logic. It could be a boolean method to indicate if there's a credit card among the payment methods.

```php
class PaymentMethodCollection extends Collection
{
	public function hasCreditCard(): bool
	{
		// ...
	}
}
```

# Options
## Graceful handling of missing keys
When you're working on a class inheriting the Collection object, you can set the ````graceful```` property to true, to enable
graceful handling of trying to access a collection element that doesn't exist. In normal circumstances, trying to access an element
that doesn't exist will throw ````KeyDoesNotExistException````. If graceful handling is enabled and you try access a non-existent key
````NULL```` will be returned.
