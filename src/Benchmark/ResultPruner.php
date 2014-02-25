<?php

namespace TylerSommer\Nice\Benchmark;

/**
 * Defines the contract any ResultPruner must follow
 */
interface ResultPruner
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