<?php
/**
 * @see https://github.com/coderello/laravel-shared-data
 */

return [

    /*
     * JavaScript namespace.
     *
     * By default the namespace is equal to 'sharedData'.
     *
     * It means that the shared data will be accessible from `window.sharedData`
     */
    'js_namespace' => 'sharedData',

    /*
     * The settings for the JavaScript helper function that allows
     * retrieving the shared data on the front-end side easily.
     *
     * Example: `shared('user.email')`
     */
    'js_helper' => [
        /*
         * Determines whether the JavaScript helper should be included
         * alongside with the shared data.
         */
        'enabled' => true,

        /*
         * The function name for the JavaScript helper.
         */
        'name' => 'shared',
    ],

    /*
     * The settings for the Blade directive.
     */
    'blade_directive' => [
        /*
         * Blade directive name.
         *
         * By default the Blade directive named 'shared'.
         *
         * It means that the shared data rendering will be available in view files via `@shared`.
         */
        'name' => 'shared',
    ],
];
