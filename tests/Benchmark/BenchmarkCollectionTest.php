<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace TylerSommer\Nice\Tests\Benchmark;

use TylerSommer\Nice\Benchmark\Benchmark;
use TylerSommer\Nice\Benchmark\BenchmarkCollection;
use TylerSommer\Nice\Benchmark\ResultPrinter\NullPrinter;
use TylerSommer\Nice\Benchmark\ResultPrinterInterface;
use TylerSommer\Nice\Benchmark\TestInterface;

class BenchmarkCollectionkTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A simple test
     */
    public function testSimpleTest()
    {
        $collection = new BenchmarkCollection('Test');
        $benchmark = $this->getMockForAbstractClass('TylerSommer\Nice\Benchmark\BenchmarkInterface');
        $benchmark->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(array()));

        $benchmarkTwo = $this->getMockForAbstractClass('TylerSommer\Nice\Benchmark\BenchmarkInterface');
        $benchmarkTwo->expects($this->once())
            ->method('execute')
            ->will($this->returnValue(array()));
        
        $collection->addBenchmark($benchmark);
        $collection->addBenchmark($benchmarkTwo);

        $collection->execute();
    }
}