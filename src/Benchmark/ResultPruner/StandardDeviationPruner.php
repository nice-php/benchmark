<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace TylerSommer\Nice\Benchmark\ResultPruner;

use TylerSommer\Nice\Benchmark\ResultPrunerInterface;

class StandardDeviationPruner implements ResultPrunerInterface
{
    /**
     * @var int
     */
    private $deviations;

    /**
     * Constructor
     *
     * @param int $deviations
     */
    public function __construct($deviations = 3)
    {
        $this->deviations = $deviations;
    }

    /**
     * Prune the results
     *
     * @param array $results
     *
     * @return array The pruned results
     */
    public function prune(array $results)
    {
        $mean = array_sum($results) / count($results);
        $deviation = $this->deviations * $this->standardDeviation($results);
        $lower = $mean - $deviation;
        $upper = $mean + $deviation;

        return array_values(array_filter($results, function ($val) use ($lower, $upper) {
                return $val >= $lower && $val <= $upper;
            }));
    }

    /**
     * Returns one standard deviation for the given results
     *
     * @param array $results
     *
     * @return float
     */
    private function standardDeviation(array $results)
    {
        $mean = array_sum($results) / count($results);
        $initial = 0;
        $f = function ($carry, $val) use ($mean) {
            return $carry + pow($val - $mean, 2);
        };
        $sum = array_reduce($results, $f, $initial);
        $n = count($results) - 1;

        return $n === 0 ? 0 : sqrt($sum / $n);
    }

    /**
     * Gets a string describing this pruner
     *
     * @return string
     */
    public function getDescription()
    {
        return sprintf('Values that fall outside of %s standard deviations of the mean are discarded.', $this->deviations);
    }
}
