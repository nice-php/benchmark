<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

use TylerSommer\Nice\Benchmark\Benchmark;
use TylerSommer\Nice\Benchmark\BenchmarkCollection;

require __DIR__ . '/../vendor/autoload.php';

/**
 * A string matching benchmark
 * 
 * @return Benchmark
 */
function setupStringBenchmark()
{
    $benchmark = new Benchmark(100000);
    $benchmark->register('preg_match', function() {
            assert(preg_match('/^test/', 'testing'));
        });

    $benchmark->register('strpos', function() {
            assert(strpos('testing', 'test') === 0);
        });
    
    return $benchmark;
}

/**
 * A foreach benchmark
 * 
 * @return Benchmark
 */
function setupForeachBenchmark()
{
    $arr = range(1, 10000);

    $benchmark = new Benchmark(10000);
    $benchmark->register('foreach with value', function() use ($arr) {
            foreach ($arr as $value) {

            }
        });

    $benchmark->register('foreach with key, value', function() use ($arr) {
            foreach ($arr as $key => $value) {

            }
        });
    
    return $benchmark;
}

// Setup a bunch of benchmarks
$collection = new BenchmarkCollection();
$collection->addBenchmark(setupStringBenchmark());
$collection->addBenchmark(setupForeachBenchmark());

// Execute all the benchmarks in the collection
$collection->execute();