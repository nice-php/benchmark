<?php

namespace TylerSommer\Nice\Benchmark;

/**
 * Defines the contract any test must follow
 */
interface Test
{
    /**
     * @return string
     */
    public function getName();

    /**
     * Execute the test the specified number of times.
     *
     * @param int   $iterations
     * @param array $parameters
     *
     * @return array|float[] Array of results
     */
    public function run($iterations, array $parameters = array());
}