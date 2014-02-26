<?php

namespace TylerSommer\Nice\Benchmark;

class BenchmarkCollection implements BenchmarkInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array|BenchmarkInterface[]
     */
    protected $benchmarks = array();

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name = 'A simple bunch of benchmarks')
    {
        $this->name = $name;
    }

    /**
     * Add a Benchmark to this Collection
     *
     * @param BenchmarkInterface $benchmark
     */
    public function addBenchmark(BenchmarkInterface $benchmark)
    {
        $this->benchmarks[] = $benchmark;
    }

    /**
     * Get the name of the Benchmark
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get all registered Tests
     *
     * @return array|\TylerSommer\Nice\Benchmark\TestInterface[]
     */
    public function getTests()
    {
        $tests = array();
        foreach ($this->benchmarks as $benchmark) {
            $tests += $benchmark->getTests();
        }

        return $tests;
    }

    /**
     * Execute the registered tests and return the results
     *
     * @return array The results
     */
    public function execute()
    {
        $results = array();
        foreach ($this->benchmarks as $benchmark) {
            $results += $benchmark->execute();
        }

        return $results;
    }

    /**
     * @param array|\TylerSommer\Nice\Benchmark\BenchmarkInterface[] $benchmarks
     */
    public function setBenchmarks($benchmarks)
    {
        $this->benchmarks = $benchmarks;
    }

    /**
     * @return array|\TylerSommer\Nice\Benchmark\BenchmarkInterface[]
     */
    public function getBenchmarks()
    {
        return $this->benchmarks;
    }
}
