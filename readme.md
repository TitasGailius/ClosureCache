# ClosureCache

A simple PHP cache mechanism for storing method, function or closure results.\
It calculates result of the closure once and returns it on subsequent calls.

## Usage
```php
<?php

use ClosureCache\ClosureCache;

return once(function () {
    // Code...
});

// OR

return ClosureCache::remember(function () {
    // Code...
});
```

## Installation

### With composer
```
$ composer require titasgailius/closure-cache
```

```json
{
    "require": {
        "titasgailius/closure-cache": "~1.00"
    }
}
```


## Example
#### Before
```php
<?php

use ClosureCache\ClosureCache;

class SomeClass
{
    public static function think()
    {
        sleep(10);

        return 'It takes some time to process this.';
    }
}

/**
 * 10 seconds to process it.
 */
SomeClass::think();

/**
 * Another 10 seconds to process it
 * which makes it 20 seconds in total.
 */
SomeClass::think();
```

#### After
```php
<?php

use ClosureCache\ClosureCache;

class SomeClass
{
    public static function think()
    {
        return once(function () {
            sleep(10);

            return 'It takes some time to process this.';
        });
    }
}

/**
 * 10 seconds to process
 */
SomeClass::think();

/**
 * ClosureCache detects that this was already
 * processed and returns it from the cache.
 */
SomeClass::think();
```

#### ClosureCache is parameter-sensitive
```php
<?php

use ClosureCache\ClosureCache;

class SomeClass
{
    public static function think($message)
    {
        return once(function () use ($message) {
            sleep(10);

            return $message;
        });
    }
}

/**
 * 10 seconds to process
 */
SomeClass::think('foo');

/**
 * Another 10 seconds to process it because
 * different parameters were passed.
 */
SomeClass::think('bar');
```
