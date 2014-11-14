<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Nice\Benchmark;

/**
 * Defines the contract any ResultPrunerInterface must follow
 */
interface ResultPrunerInterface
{
    /**
     * Prune the results
     *
     * @param array $results
     *
     * @return array The pruned results
     */
    public function prune(array $results);

    /**
     * Gets a string describing this pruner
     *
     * @return string
     */
    public function getDescription();
}
