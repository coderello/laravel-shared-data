<?php

namespace Coderello\SharedData\Tests;

use Orchestra\Testbench\TestCase;
use Coderello\SharedData\Providers\SharedDataServiceProvider;

abstract class AbstractTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SharedDataServiceProvider::class,
        ];
    }
}
