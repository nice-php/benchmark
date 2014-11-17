A nice PHP benchmarking framework
=================================

[![Build Status](https://travis-ci.org/nice-php/nice-bench.png?branch=master)](https://travis-ci.org/nice-php/nice-bench)

A simple PHP benchmark, useful for the every day micro-optimizer.

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Nice\Benchmark\Benchmark;

$benchmark = new Benchmark(100000, 'String matching');
$benchmark->register('preg_match', function() {
        assert(preg_match('/^test/', 'testing'));
    });

$benchmark->register('strpos', function() {
        assert(strpos('testing', 'test') === 0);
    });

$benchmark->execute();
```

```
Running "String matching" consisting of 2 tests, 100,000 iterations...
Values that fall outside of 3 standard deviations of the mean are discarded.

For preg_match out of 98,997 runs, average time was 0.0000118057 seconds.
For strpos out of 99,871 runs, average time was 0.0000104146 seconds.

Results:
Test Name                          	Time                	+ Interval          	Change
strpos                             	0.0000104146        	+0.0000000000       	baseline
preg_match                         	0.0000118057        	+0.0000013912       	13% slower
```

Installation
------------

The recommended way to install Nice Bench is through [Composer](http://getcomposer.org/). Just run the 
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

use Nice\Benchmark\Benchmark;

$arr = range(1, 10000);

$benchmark = new Benchmark(10000, 'foreach');
$benchmark->register('foreach with value', function() use ($arr) {
        foreach ($arr as $value) {
        
        }
    });

$benchmark->register('foreach with key, value', function() use ($arr) {
        foreach ($arr as $key => $value) {
            
        }
    });

$benchmark->execute();
```

Then run `tests.php` in your terminal:

```bash
$ php tests.php
Running "foreach" consisting of 2 tests, 10,000 iterations...
Values that fall outside of 3 standard deviations of the mean are discarded.

For foreach with value out of 9,871 runs, average time was 0.0011523914 seconds.
For foreach with key, value out of 9,874 runs, average time was 0.0016814657 seconds.


Results:
Test Name                          	Time                	+ Interval          	Change
foreach with value                 	0.0011523914        	+0.0000000000       	baseline
foreach with key, value            	0.0016814657        	+0.0005290744       	46% slower
```

For another example, check out [example.php](example/example.php).