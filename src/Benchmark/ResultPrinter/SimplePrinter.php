<?php

namespace TylerSommer\Nice\Benchmark\ResultPrinter;

use TylerSommer\Nice\Benchmark\ResultPrinter;

/**
 * A simple ResultPrinter
 */
class SimplePrinter implements ResultPrinter
{
    /**
     * Prints the results
     *
     * @param array $results
     */
    public function output(array $results)
    {
        asort($results);
        reset($results);
        $fastestResult = each($results);
        echo "\n\nResults:\n";
        printf("%-35s\t%-20s\t%-20s\t%s\n", "Test Name", "Time", "+ Interval", "Change");
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
                "%-35s\t%-20s\t%-20s\t%s\n",
                $name,
                sprintf("%.10f", $result),
                "+" . sprintf("%.10f", $interval),
                $change
            );
        }
    }
}