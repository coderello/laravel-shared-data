<?php

namespace Coderello\SharedData\Tests;

use Coderello\SharedData\Providers\SharedDataServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        view()->addLocation(__DIR__.'/views');
    }

    protected function getPackageProviders($app)
    {
        return [
            SharedDataServiceProvider::class,
        ];
    }
}
