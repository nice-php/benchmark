<?php

namespace TylerSommer\Nice\Benchmark;

use TylerSommer\Nice\Benchmark\ResultPrinter\SimplePrinter;
use TylerSommer\Nice\Benchmark\Test\CallableTest;

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
     * @var array|Test[]
     */
    protected $tests = array();

    /**
     * @var array
     */
    protected $results = array();

    /**
     * @var ResultPrinter
     */
    private $resultPrinter;

    /**
     * @param int           $length        The number of iterations per test
     * @param ResultPrinter $resultPrinter The ResultPrinter to be used
     */
    public function __construct($length = 1000, ResultPrinter $resultPrinter = null)
    {
        $this->length = $length;
        $this->resultPrinter = $resultPrinter ?: new SimplePrinter();
    }

    /**
     * Register a test
     *
     * @param string   $name     (Friendly) Name of the test
     * @param callback $callback A valid callback
     */
    public function register($name, $callback)
    {
        $this->tests[] = new CallableTest($name, $callback);
    }

    /**
     * Execute the registered tests and display the results
     */
    public function execute()
    {
        $adjustment = round($this->length * .1, 0);
        echo "Running " . count($this->tests) . " tests, {$this->length} times each...\nThe {$adjustment} highest and lowest results will be disregarded.\n\n";
        foreach ($this->tests as $test) {
            $results = $test->run($this->length);
            sort($results);
            // remove the lowest and highest 10% (leaving 80% of results)
            for ($x = 0; $x < $adjustment; $x++) {
                array_shift($results);
                array_pop($results);
            }
            $avg = array_sum($results) / count($results);
            echo "For " . $test->getName() . ", out of " . count($results) . " runs, average time was: " . sprintf(
                    "%.10f",
                    $avg
                ) . " secs.\n";
            $this->results[$test->getName()] = $avg;
        }
        
        $this->resultPrinter->output($this->results);
    }
}