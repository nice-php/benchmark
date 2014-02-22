<?php

namespace TylerSommer\Nice\Benchmark;

/**
 * A Simple Operation Benchmark Class
 */
class Benchmark
{
    /**
     * @var int
     */
    protected $length;

    /**
     * @var array|callable[]
     */
    protected $tests = array();

    /**
     * @var array
     */
    protected $results = array();

    /**
     * @param int $length The number of iterations per test
     */
    public function __construct($length = 1000)
    {
        $this->length = $length;
    }

    /**
     * Register a test
     *
     * @param string   $name     (Friendly) Name of the test
     * @param callback $callback A valid callback
     */
    public function register($name, $callback)
    {
        $this->tests[$name] = $callback;
    }

    /**
     * Execute the registered tests and display the results
     */
    public function execute()
    {
        $adjustment = round($this->length * .1, 0);
        echo "Running " . count($this->tests) . " tests, {$this->length} times each...\nThe {$adjustment} highest and lowest results will be disregarded.\n\n";
        foreach ($this->tests as $name => $test) {
            $results = array();
            for ($x = 0; $x < $this->length; $x++) {
                ob_start();
                $start = time() + microtime();
                call_user_func($test);
                $results[] = round((time() + microtime()) - $start, 10);
                ob_end_clean();
            }
            sort($results);
            // remove the lowest and highest 10% (leaving 80% of results)
            for ($x = 0; $x < $adjustment; $x++) {
                array_shift($results);
                array_pop($results);
            }
            $avg = array_sum($results) / count($results);
            echo "For {$name}, out of " . count($results) . " runs, average time was: " . sprintf(
                    "%.10f",
                    $avg
                ) . " secs.\n";
            $this->results[$name] = $avg;
        }
        asort($this->results);
        reset($this->results);
        $fastestResult = each($this->results);
        reset($this->results);
        echo "\n\nResults:\n";
        printf("%-35s\t%-20s\t%-20s\t%s\n", "Test Name", "Time", "+ Interval", "Change");
        foreach ($this->results as $name => $result) {
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