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

$collection->forEach(function($item) {
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
```

# Example use of other methods
## forEach
````php
$collection = (new Collection)
	->push(1, 2, 3)
	->forEach(function($item) {
		return $item * 2;
	});

// 2, 4, 6
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
