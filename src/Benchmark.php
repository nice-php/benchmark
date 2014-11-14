<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Nice\Benchmark;

use Nice\Benchmark\ResultPrinter\SimplePrinter;
use Nice\Benchmark\ResultPruner\StandardDeviationPruner;
use Nice\Benchmark\Test\CallableTest;

/**
 * A simple operation Benchmark
 */
class Benchmark implements BenchmarkInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description = '';

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
     * @var ResultPrinterInterface
     */
    private $resultPrinter;

    /**
     * @var ResultPrunerInterface
     */
    private $resultPruner;

    /**
     * Constructor
     *
     * @param int                    $iterations    The number of iterations per test
     * @param string                 $name          The name of this Benchmark
     * @param ResultPrinterInterface $resultPrinter The ResultPrinterInterface to be used
     * @param ResultPrunerInterface  $resultPruner  The ResultPrunerInterface to be used
     */
    public function __construct(
        $iterations = 1000,
        $name = 'A simple benchmark',
        ResultPrinterInterface $resultPrinter = null,
        ResultPrunerInterface $resultPruner = null
    ) {
        $this->name          = (string) $name;
        $this->iterations    = (int) $iterations;
        $this->resultPrinter = $resultPrinter ?: new SimplePrinter();
        $this->resultPruner  = $resultPruner  ?: new StandardDeviationPruner();
    }

    /**
     * Execute the registered tests and display the results
     */
    public function execute()
    {
        $this->resultPrinter->printBenchmarkIntro($this);

        $results = array();
        foreach ($this->tests as $test) {
            $testResults = array();
            for ($i = 0; $i < $this->iterations; $i++) {
                $start = time() + microtime();
                $test->run($this->parameters);
                $testResults[] = round((time() + microtime()) - $start, 10);
            }

            $testResults = $this->resultPruner->prune($testResults);

            $this->resultPrinter->printSingleTestResult($test, $testResults);
            $results[$test->getName()] = $testResults;
        }

        $this->resultPrinter->printBenchmarkSummary($this, $results);
        $this->resultPrinter->printBreak();

        return $results;
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
     * Add a Test to the Benchmark
     *
     * @param TestInterface $test
     */
    public function addTest(TestInterface $test)
    {
        $this->tests[] = $test;
    }

    /**
     * Get all registered Tests
     *
     * @return array|\Nice\Benchmark\TestInterface[]
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * Get the Result Pruner
     *
     * @return \Nice\Benchmark\ResultPrunerInterface
     */
    public function getResultPruner()
    {
        return $this->resultPruner;
    }

    /**
     * Get the Result Printer
     *
     * @return \Nice\Benchmark\ResultPrinterInterface
     */
    public function getResultPrinter()
    {
        return $this->resultPrinter;
    }

    /**
     * Get the number of iterations the Benchmark should execute each test
     *
     * @return int
     */
    public function getIterations()
    {
        return $this->iterations;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @param int $iterations
     */
    public function setIterations($iterations)
    {
        $this->iterations = (int) $iterations;
    }

    /**
     * @param \Nice\Benchmark\ResultPrinterInterface $resultPrinter
     */
    public function setResultPrinter(ResultPrinterInterface $resultPrinter)
    {
        $this->resultPrinter = $resultPrinter;
    }

    /**
     * @param \Nice\Benchmark\ResultPrunerInterface $resultPruner
     */
    public function setResultPruner(ResultPrunerInterface $resultPruner)
    {
        $this->resultPruner = $resultPruner;
    }

    /**
     * Get a short description about the Benchmark
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = (string) $description;
    }
}
