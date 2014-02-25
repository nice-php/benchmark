<?php

namespace TylerSommer\Nice\Benchmark\ResultPrinter;

use TylerSommer\Nice\Benchmark\Benchmark;
use TylerSommer\Nice\Benchmark\ResultPrinter;
use TylerSommer\Nice\Benchmark\Test;

/**
 * Prints results in GitHub flavored Markdown
 *
 * @author Rouven Weßling
 */
class MarkdownPrinter implements ResultPrinter
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
        $results = array_map(function($result) {
                return array_sum($result) / count($result);
            }, $results);
        
        $template = "%s | %s | %s | %s\n";
        asort($results);
        reset($results);
        $fastestResult = each($results);
        echo "\n\nResults:\n\n";
        printf($template, "Test Name", "Time", "+ Interval", "Change");
        printf($template, "---------", "----", "----------", "------");
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
                $template,
                $name,
                sprintf("%.10f", $result),
                "+" . sprintf("%.10f", $interval),
                $change
            );
        }
    }
}
