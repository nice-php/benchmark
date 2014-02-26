<?php

namespace TylerSommer\Nice\Tests\Benchmark;

use TylerSommer\Nice\Benchmark\Benchmark;
use TylerSommer\Nice\Benchmark\ResultPrinter;
use TylerSommer\Nice\Benchmark\Test;

class BenchmarkTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A simple test
     */
    public function testSimpleTest()
    {
        $count = 0;
        
        $benchmark = new Benchmark(10, new NullPrinter());
        $benchmark->register('test', function() use (&$count) {
                $count++;
            });
        
        $benchmark->execute();
        
        $this->assertEquals(10, $count);
    }

    /**
     * A test with parameters
     */
    public function testTestWithParameters()
    {
        $called = false;

        $benchmark = new Benchmark(1, new NullPrinter());
        $benchmark->register('test', function($value) use (&$called) {
                if ($value === 'a value') {
                    $called = true;
                }
            });
        $benchmark->setParameters(array('a value'));

        $benchmark->execute();

        $this->assertTrue($called);
    }
}

class NullPrinter implements ResultPrinter
{
    /**
     * Outputs an introduction prior to test execution
     *
     * @param Benchmark $benchmark
     */
    public function printIntro(Benchmark $benchmark)
    {
        // no op
    }

    /**
     * Print the result of a single result
     *
     * @param Test  $test
     * @param array $results
     */
    public function printSingleResult(Test $test, array $results)
    {
        // no op
    }

    /**
     * Prints the completed benchmarks summary
     *
     * @param Benchmark $benchmark
     * @param array     $results
     */
    public function printResultSummary(Benchmark $benchmark, array $results)
    {
        // no op
    }
}