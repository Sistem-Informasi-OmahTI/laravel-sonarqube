<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private $mock = [];

    protected function mockeryMock(string $class)
    {
        $this->mock[$class] = Mockery::mock($class);
        app()->instance($class, $this->mock[$class]);

        return $this->mock[$class];
    }
}
