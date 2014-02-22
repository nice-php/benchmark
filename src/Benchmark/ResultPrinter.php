<?php

namespace TylerSommer\Nice\Benchmark;

/**
 * Defines the contract any ResultPrinter must follow
 */
interface ResultPrinter
{
    /**
     * Prints the results
     * 
     * @param array $results
     */
    public function output(array $results);
}