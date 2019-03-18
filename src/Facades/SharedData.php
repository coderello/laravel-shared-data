<?php

namespace Coderello\SharedData\Facades;

use Illuminate\Support\Facades\Facade;

class SharedData extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Coderello\SharedData\SharedData::class;
    }
}
