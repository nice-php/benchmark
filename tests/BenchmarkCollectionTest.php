<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Nice\Tests\Benchmark;

use Nice\Benchmark\Benchmark;
use Nice\Benchmark\BenchmarkCollection;

class BenchmarkCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A simple test
     */
    public function testSimpleTest()
    {
        $collection = new BenchmarkCollection('Test');
        $benchmark = $this->getMockForAbstractClass('Nice\Benchmark\BenchmarkInterface');
        $benchmark->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(array()));

        $benchmarkTwo = $this->getMockForAbstractClass('Nice\Benchmark\BenchmarkInterface');
        $benchmarkTwo->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(array()));

        $collection->addBenchmark($benchmark);
        $collection->addBenchmark($benchmarkTwo);

        $collection->execute();
    }
}
