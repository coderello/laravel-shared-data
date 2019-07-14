<?php

namespace Coderello\SharedData\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Coderello\SharedData\SharedData
 *
 * @method static \Coderello\SharedData\SharedData put(mixed $key, mixed $value = null)
 * @method static mixed get(mixed $key = null)
 * @method static string toJson(int $options = 0)
 * @method static string render()
 */
class SharedData extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return \Coderello\SharedData\SharedData::class;
    }
}
