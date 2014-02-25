<?php

namespace TylerSommer\Nice\Benchmark;

use TylerSommer\Nice\Benchmark\ResultPrinter\SimplePrinter;
use TylerSommer\Nice\Benchmark\ResultPruner\StandardDeviationPruner;
use TylerSommer\Nice\Benchmark\Test\CallableTest;

/**
 * A Simple Operation Benchmark Class
 */
class Benchmark
{
    /**
     * @var int
     */
    protected $iterations;

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
     * @var ResultPruner
     */
    private $resultPruner;

    /**
     * @param int           $iterations    The number of iterations per test
     * @param ResultPrinter $resultPrinter The ResultPrinter to be used
     * @param ResultPruner  $resultPruner  The ResultPruner to be used
     */
    public function __construct(
        $iterations = 1000, 
        ResultPrinter $resultPrinter = null,
        ResultPruner $resultPruner = null
    ) {
        $this->iterations = $iterations;
        $this->resultPrinter = $resultPrinter ?: new SimplePrinter();
        $this->resultPruner = $resultPruner ?: new StandardDeviationPruner();
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
        $this->resultPrinter->printIntro($this);
        
        foreach ($this->tests as $test) {
            $results = $test->run($this->iterations);
            $results = $this->resultPruner->prune($results);
            $avg = array_sum($results) / count($results);
            
            $this->resultPrinter->printSingleResult($test, $results);
            
            $this->results[$test->getName()] = $avg;
        }
        
        $this->resultPrinter->printResultSummary($this, $this->results);
    }

    /**
     * @return array|\TylerSommer\Nice\Benchmark\Test[]
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * @return \TylerSommer\Nice\Benchmark\ResultPruner
     */
    public function getResultPruner()
    {
        return $this->resultPruner;
    }

    /**
     * @return \TylerSommer\Nice\Benchmark\ResultPrinter
     */
    public function getResultPrinter()
    {
        return $this->resultPrinter;
    }

    /**
     * @return int
     */
    public function getIterations()
    {
        return $this->iterations;
    }
}