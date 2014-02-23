<?php

namespace TylerSommer\Nice\Benchmark\ResultPrinter;

use TylerSommer\Nice\Benchmark\ResultPrinter;

/**
 * Prints results in GitHub flavored Markdown
 *
 * @author Rouven Weßling
 */
class MarkdownPrinter implements ResultPrinter
{
    /**
     * Prints the results
     *
     * @param array $results
     */
    public function output(array $results)
    {
        $template = "%s | %s | %s | %s\n";
        asort($results);
        reset($results);
        $fastestResult = each($results);
        echo "\n\nResults:\n";
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
