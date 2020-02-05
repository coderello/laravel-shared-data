---
title: Sharing data
section: Getting Started
weight: 900
featherIcon: package
---

You can share any data you want from any part or your application (middleware, controller, service provider etc.)

```php
use Coderello\SharedData\Facades\SharedData;

// using the facade
SharedData::put([
    'user' => auth()->user(),
    'post' => Post::first(),
    'app' => [
        'name' => config('app.name'),
        'environment' => config('app.env'),
    ],
]);

// using the helper
share([
    'user' => auth()->user(),
    'post' => Post::first(),
    'app' => [
        'name' => config('app.name'),
        'environment' => config('app.env'),
    ],
]);
```

And get this data on the frontend side directly from `window.sharedData` (use can modify the namespace in the config file) like so:

```js
const user = window.sharedData.user;
```

Or using the global built-in helper:
```js
const user = shared('user');
```

> You can get more info on the global built-in helper on the [JavaScript helper]({{base}}/{{version}}/javascript-helper) page.

![console.log(window.sharedData);]({{assets}}/window-shared-data.png)
