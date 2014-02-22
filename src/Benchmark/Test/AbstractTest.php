<?php

namespace TylerSommer\Nice\Benchmark\Test;

use TylerSommer\Nice\Benchmark\Test;

/**
 * Abstract base class for any Test
 */
abstract class AbstractTest implements Test
{
    /**
     * Execute the test the specified number of times.
     *
     * @param int $iterations
     *
     * @return array|float[] Array of results
     */
    public function run($iterations)
    {
        $results = array();
        for ($i = 0; $i < $iterations; $i++) {
            $start = time() + microtime();
            
            $this->doRun();

            $results[] = round((time() + microtime()) - $start, 10);
        }
        
        return $results;
    }

    /**
     * Executes the test
     */
    abstract protected function doRun();
}