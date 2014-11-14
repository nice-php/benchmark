<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Nice\Tests\Benchmark;

use Nice\Benchmark\Benchmark;
use Nice\Benchmark\ResultPrinter\NullPrinter;
use Nice\Benchmark\TestInterface;

class BenchmarkTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A simple test
     */
    public function testSimpleTest()
    {
        $test = $this->getMockForAbstractClass('Nice\Benchmark\TestInterface');
        $test->expects($this->exactly(10))
            ->method('run');
        $benchmark = new Benchmark(10, 'Test', new NullPrinter());
        $benchmark->addTest($test);

        $benchmark->execute();
    }

    /**
     * A test with parameters
     */
    public function testTestWithParameters()
    {
        $test = $this->getMockForAbstractClass('Nice\Benchmark\TestInterface');
        $test->expects($this->exactly(10))
            ->method('run')
            ->with(array('a value'));
        $benchmark = new Benchmark(10, 'Test', new NullPrinter());
        $benchmark->addTest($test);
        $benchmark->setParameters(array('a value'));

        $benchmark->execute();
    }
}
