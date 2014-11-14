<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Nice\Benchmark;

/**
 * Defines the contract any Benchmark must follow
 */
interface BenchmarkInterface
{
    /**
     * Get the name of the Benchmark
     *
     * @return string
     */
    public function getName();

    /**
     * Get a short description about the Benchmark
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get all registered Tests
     *
     * @return array|\TylerSommer\Nice\Benchmark\TestInterface[]
     */
    public function getTests();

    /**
     * Execute the registered tests and return the results
     *
     * @return array The results
     */
    public function execute();
}
