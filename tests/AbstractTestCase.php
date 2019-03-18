<?php

namespace Coderello\SharedData\Tests;

use Coderello\SharedData\Providers\SharedDataServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class AbstractTestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SharedDataServiceProvider::class,
        ];
    }
}
