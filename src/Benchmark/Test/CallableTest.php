<?php

namespace TylerSommer\Nice\Benchmark\Test;

class CallableTest extends AbstractTest
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
     * Executes the test
     */
    protected function doRun(array $parameters)
    {
        // TODO: Some Reflection of some kind?
        call_user_func_array($this->test, array_values($parameters));
    }
}