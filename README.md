nice-bench
==========

A nice, simple PHP benchmark.

```php
<?php

use TylerSommer\Nice\Benchmark\Benchmark;
use TylerSommer\Nice\Benchmark\ResultPrinter\MarkdownPrinter;

$benchmark = new Benchmark(100000, new MarkdownPrinter());
$benchmark->register('preg_match', function() {
        assert(preg_match('/^test/', 'testing'));
    });

$benchmark->register('strpos', function() {
        assert(strpos('testing', 'test') === 0);
    });

$benchmark->execute();
```

```
Running 2 tests, 100000 times each...
Values that fall outside of 3 standard deviations of the mean will be discarded.

For preg_match out of 97899 runs, average time was 0.0000115320 seconds.
For strpos out of 98941 runs, average time was 0.0000103866 seconds.
```

Results:

Test Name | Time | + Interval | Change
--------- | ---- | ---------- | ------
strpos | 0.0000103866 | +0.0000000000 | baseline
preg_match | 0.0000115320 | +0.0000011454 | 11% slower