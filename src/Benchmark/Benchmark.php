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
     * @param callable $callable A valid callable
     */
    public function register($name, $callable)
    {
        $this->tests[] = new CallableTest($name, $callable);
    }

    /**
     * Execute the registered tests and display the results
     */
    public function execute()
    {
        printf(
            "Running %d tests, %d times each...\nValues that fall outside of 3 standard deviations of the mean will be discarded.\n\n",
            count($this->tests),
            $this->length
        );
        foreach ($this->tests as $test) {
            $results = $test->run($this->length);
            $results = $this->pruneResults($results);
            $avg = array_sum($results) / count($results);
            printf(
                "For %s out of %d runs, average time was %.10f seconds.\n",
                $test->getName(),
                count($results),
                $avg
            );
            $this->results[$test->getName()] = $avg;
        }
        
        $this->resultPrinter->output($this->results);
    }

    protected function pruneResults(array $data) {
        $mean = array_sum($data) / count($data);
        $three_deviations = 3 * $this->standardDeviation($data, $mean);
        $lower = $mean - $three_deviations;
        $upper = $mean + $three_deviations;
        return array_filter($data, function($val) use ($lower, $upper) {
            return $val >= $lower && $val <= $upper;
        });
    }

    private function standardDeviation(array $data, $mean) {
        $initial = 0;
        $f = function ($carry, $val) use ($mean) {
            return $carry + pow($val - $mean, 2);
        };
        $sum = array_reduce($data, $f, $initial);
        $n = count($data) - 1;
        return sqrt($sum / $n);
    }

}