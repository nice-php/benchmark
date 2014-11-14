<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Nice\Benchmark\ResultPrinter;

use Nice\Benchmark\Benchmark;
use Nice\Benchmark\ResultPrinterInterface;
use Nice\Benchmark\TestInterface;

/**
 * A simple ResultPrinterInterface
 */
class SimplePrinter implements ResultPrinterInterface
{
    /**
     * Outputs an introduction prior to test execution
     *
     * @param Benchmark $benchmark
     */
    public function printBenchmarkIntro(Benchmark $benchmark)
    {
        printf(
            "Running \"%s\" consisting of %s tests, %s iterations...\n%s\n\n",
            $benchmark->getName(),
            number_format(count($benchmark->getTests())),
                number_format($benchmark->getIterations()),
            $benchmark->getResultPruner()->getDescription()
        );
    }

    /**
     * Print the result of a single result
     *
     * @param TestInterface $test
     * @param array         $results
     */
    public function printSingleTestResult(TestInterface $test, array $results)
    {
        printf(
            "For %s out of %s runs, average time was %.10f seconds.\n",
            $test->getName(),
            number_format(count($results)),
            array_sum($results) / count($results)
        );
    }

    /**
     * Prints the results
     *
     * @param array $results
     */
    public function printBenchmarkSummary(Benchmark $benchmark, array $results)
    {
        $format = "%-35s\t%-20s\t%-20s\t%s\n";

        $results = array_map(function ($result) {
                return array_sum($result) / count($result);
            }, $results);

        asort($results);
        reset($results);
        $fastestResult = each($results);
        echo "\n\nResults:\n";
        printf($format, "Test Name", "Time", "+ Interval", "Change");
        foreach ($results as $name => $result) {
            $interval = $result - $fastestResult["value"];
            $change   = round((1 - $result / $fastestResult["value"]) * 100, 0);
            if ($change == 0) {
                $change = 'baseline';
            } else {
                $faster = true; // Cant really ever be faster, now can it
                if ($change < 0) {
                    $faster = false;
                    $change *= -1;
                }
                $change .= '% ' . ($faster ? 'faster' : 'slower');
            }

            printf(
                $format,
                $name,
                sprintf("%.10f", $result),
                "+" . sprintf("%.10f", $interval),
                $change
            );
        }
    }

    /**
     * Prints a break, a separation between benchmarks
     */
    public function printBreak()
    {
        print("\n\n");
    }
}
