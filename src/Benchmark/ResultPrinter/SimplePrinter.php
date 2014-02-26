<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace TylerSommer\Nice\Benchmark\ResultPrinter;

use TylerSommer\Nice\Benchmark\Benchmark;
use TylerSommer\Nice\Benchmark\ResultPrinter;
use TylerSommer\Nice\Benchmark\Test;

/**
 * A simple ResultPrinter
 */
class SimplePrinter implements ResultPrinter
{
    /**
     * Outputs an introduction prior to test execution
     * 
     * @param Benchmark $benchmark
     */
    public function printIntro(Benchmark $benchmark)
    {
        printf(
            "Running %d tests, %d times each...\n%s\n\n",
            count($benchmark->getTests()),
            $benchmark->getIterations(),
            $benchmark->getResultPruner()->getDescription()
        );
    }

    /**
     * Print the result of a single result
     *
     * @param Test  $test
     * @param array $results
     */
    public function printSingleResult(Test $test, array $results)
    {
        printf(
            "For %s out of %d runs, average time was %.10f seconds.\n",
            $test->getName(),
            count($results),
            array_sum($results) / count($results)
        );
    }
    
    /**
     * Prints the results
     *
     * @param array $results
     */
    public function printResultSummary(Benchmark $benchmark, array $results)
    {
        $format = "%-35s\t%-20s\t%-20s\t%s\n";

        $results = array_map(function($result) {
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
}