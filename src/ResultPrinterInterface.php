<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Nice\Benchmark;

/**
 * Defines the contract any ResultPrinterInterface must follow
 */
interface ResultPrinterInterface
{
    /**
     * Outputs an introduction prior to test execution
     *
     * @param Benchmark $benchmark
     */
    public function printBenchmarkIntro(Benchmark $benchmark);

    /**
     * Print the result of a single result
     *
     * @param TestInterface $test
     * @param array         $results
     */
    public function printSingleTestResult(TestInterface $test, array $results);

    /**
     * Prints the completed benchmarks summary
     *
     * @param Benchmark $benchmark
     * @param array     $results
     */
    public function printBenchmarkSummary(Benchmark $benchmark, array $results);

    /**
     * Prints a break, a separation between benchmarks
     */
    public function printBreak();
}
