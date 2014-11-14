<?php

/*
 * Copyright (c) Tyler Sommer
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Nice\Benchmark\Test;

use Nice\Benchmark\TestInterface;

class CallableTest implements TestInterface
{
    /**
     * @var
     */
    private $name;

    /**
     * @var callable
     */
    private $test;

    /**
     * Constructor
     *
     * @param string   $name
     * @param callable $test
     */
    public function __construct($name, $test)
    {
        $this->name = $name;
        $this->test = $test;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Execute the test
     *
     * @param array $parameters
     *
     * @return array|float[] Array of results
     */
    public function run(array $parameters = array())
    {
        // TODO: Some Reflection of some kind?
        call_user_func_array($this->test, array_values($parameters));
    }
}
