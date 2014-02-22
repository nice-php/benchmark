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
    public function __construct($name, callable $test)
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
    protected function doRun()
    {
        call_user_func($this->test);
    }
}