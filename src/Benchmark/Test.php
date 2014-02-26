<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

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