<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

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
     * @var array
     */
    protected $parameters = array();

    /**
     * @var array|TestInterface[]
     */
    protected $tests = array();

    /**
     * @var array
     */
    protected $results = array();

    /**
     * @var ResultPrinterInterface
     */
    private $resultPrinter;

    /**
     * @var ResultPrunerInterface
     */
    private $resultPruner;

    /**
     * @param int           $iterations    The number of iterations per test
     * @param ResultPrinterInterface $resultPrinter The ResultPrinterInterface to be used
     * @param ResultPrunerInterface  $resultPruner  The ResultPrunerInterface to be used
     */
    public function __construct(
        $iterations = 1000, 
        ResultPrinterInterface $resultPrinter = null,
        ResultPrunerInterface $resultPruner = null
    ) {
        $this->iterations = $iterations;
        $this->resultPrinter = $resultPrinter ?: new SimplePrinter();
        $this->resultPruner = $resultPruner ?: new StandardDeviationPruner();
    }

    /**
     * Set a single parameter
     * 
     * @param $name
     * @param $value
     */
    public function setParameter($name, $value)
    {
        $this->parameters[$name] = $value;
    }
    
    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
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
            $results = array();
            for ($i = 0; $i < $this->iterations; $i++) {
                $start = time() + microtime();
                $test->run($this->parameters);
                $results[] = round((time() + microtime()) - $start, 10);
            }
            
            $results = $this->resultPruner->prune($results);
            
            $this->resultPrinter->printSingleResult($test, $results);
            $this->results[$test->getName()] = $results;
        }
        
        $this->resultPrinter->printResultSummary($this, $this->results);
    }

    /**
     * @return array|\TylerSommer\Nice\Benchmark\TestInterface[]
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * @return \TylerSommer\Nice\Benchmark\ResultPrunerInterface
     */
    public function getResultPruner()
    {
        return $this->resultPruner;
    }

    /**
     * @return \TylerSommer\Nice\Benchmark\ResultPrinterInterface
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