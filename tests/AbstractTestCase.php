<?php

namespace Coderello\SharedData\Tests;

use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase;
use Coderello\SharedData\Providers\SharedDataServiceProvider;

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
