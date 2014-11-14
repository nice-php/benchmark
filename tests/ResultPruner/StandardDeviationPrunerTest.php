<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Nice\Tests\Benchmark\ResultPruner;

use Nice\Benchmark\ResultPruner\StandardDeviationPruner;

class StandardDeviationPrunerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A simple test
     */
    public function testSimplePrune()
    {
        $results = array(
            0,
            25,
            50,
            75,
            100
        );

        $this->assertEquals(50, array_sum($results) / count($results));

        $pruner = new StandardDeviationPruner(1);

        $results = $pruner->prune($results);

        $this->assertEquals(array(25, 50, 75), $results);
    }
}
