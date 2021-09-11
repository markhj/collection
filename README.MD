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

# Inheritance
You can use the "out of the box" collection objects provied in the package, but it's actually recommended to craete child collections which can provide handy methods.

```php
class MyCustomDateCollection extends Collection
{
	public function earliest()
	{
		// Custom method to return the earliest date in the collection
	}

	public function latest()
	{
		// Custom method to return the latest date in the collection
	}
}
```

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
