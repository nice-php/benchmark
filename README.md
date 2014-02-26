nice-bench
==========

A nice, simple PHP benchmark.

Installation
------------

The recommended way to install Nice is through [Composer](http://getcomposer.org/). Just run the 
`php composer.phar require` command in your project directory to install it:

```bash
php composer.phar require tyler-sommer/nice-bench:dev-master
```


Usage
-----

Create a file called `tests.php` in your project directory, and add:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use TylerSommer\Nice\Benchmark\Benchmark;
use TylerSommer\Nice\Benchmark\ResultPrinter\MarkdownPrinter;

$benchmark = new Benchmark(100000);
$benchmark->register('preg_match', function() {
        assert(preg_match('/^test/', 'testing'));
    });

$benchmark->register('strpos', function() {
        assert(strpos('testing', 'test') === 0);
    });

$benchmark->execute();
```

Then run `tests.php` in your terminal:

```bash
$ php tests.php
Running 2 tests, 100000 times each...
Values that fall outside of 3 standard deviations of the mean will be discarded.

For preg_match out of 98845 runs, average time was 0.0000118057 seconds.
For strpos out of 97444 runs, average time was 0.0000104146 seconds.


Results:
Test Name                          	Time                	+ Interval          	Change
strpos                             	0.0000104146        	+0.0000000000       	baseline
preg_match                         	0.0000118057        	+0.0000013912       	13% slower
```