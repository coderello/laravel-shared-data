<?php

if (! function_exists('shared')) {
    /**
     * @return \Coderello\SharedData\SharedData
     */
    function shared()
    {
        return app(\Coderello\SharedData\SharedData::class);
    }
}

if (! function_exists('share')) {
    /**
     * @param array $args
     * @return \Coderello\SharedData\SharedData
     */
    function share(...$args)
    {
        return app(\Coderello\SharedData\SharedData::class)->put(...$args);
    }
}
