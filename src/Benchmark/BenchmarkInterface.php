<?php
namespace TylerSommer\Nice\Benchmark;

/**
 * Defines the contract any Benchmark must follow
 */
interface BenchmarkInterface
{
    /**
     * Add a Test to the Benchmark
     * 
     * @param TestInterface $test
     */
    public function addTest(TestInterface $test);
    
    /**
     * Get all registered Tests
     * 
     * @return array|\TylerSommer\Nice\Benchmark\TestInterface[]
     */
    public function getTests();

    /**
     * Get the number of iterations the Benchmark should execute each test
     * 
     * @return int
     */
    public function getIterations();

    /**
     * Execute the registered tests and return the results
     * 
     * @return array The results
     */
    public function execute();
}