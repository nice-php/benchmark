<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace TylerSommer\Nice\Benchmark\ResultPrinter;

use TylerSommer\Nice\Benchmark\Benchmark;
use TylerSommer\Nice\Benchmark\ResultPrinterInterface;
use TylerSommer\Nice\Benchmark\TestInterface;

/**
 * A no op printer
 */
class NullPrinter implements ResultPrinterInterface
{
    /**
     * Outputs an introduction prior to test execution
     *
     * @param Benchmark $benchmark
     */
    public function printBenchmarkIntro(Benchmark $benchmark)
    {
        // no op
    }

    /**
     * Print the result of a single result
     *
     * @param TestInterface $test
     * @param array         $results
     */
    public function printSingleTestResult(TestInterface $test, array $results)
    {
        // no op
    }

    /**
     * Prints the completed benchmarks summary
     *
     * @param Benchmark $benchmark
     * @param array     $results
     */
    public function printBenchmarkSummary(Benchmark $benchmark, array $results)
    {
        // no op
    }

    /**
     * Prints a break, a separation between benchmarks
     */
    public function printBreak()
    {
        // no op
    }
}
