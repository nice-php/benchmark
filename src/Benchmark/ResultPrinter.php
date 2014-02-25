<?php

namespace TylerSommer\Nice\Benchmark;

/**
 * Defines the contract any ResultPrinter must follow
 */
interface ResultPrinter
{
    /**
     * Outputs an introduction prior to test execution
     * 
     * @param Benchmark $benchmark
     */
    public function printIntro(Benchmark $benchmark);

    /**
     * Print the result of a single result
     * 
     * @param Test  $test
     * @param array $results
     */
    public function printSingleResult(Test $test, array $results);

    /**
     * Prints the completed benchmarks summary
     *
     * @param Benchmark $benchmark
     * @param array     $results
     */
    public function printResultSummary(Benchmark $benchmark, array $results);
}