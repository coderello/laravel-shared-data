---
title: Sharing data
section: Getting Started
weight: 400
featherIcon: package
---

First of all, you need to include this line before all of your `<script>` tags in you base blade layout in order to make the shared data available in all of those scripts.

```blade
@shared
```

Now you can share any data you want from any part or your application (middleware, controller, service provider etc.)

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

And get this data on the frontend side from `window.sharedData` (use can modify the namespace in the config file).

![console.log(window.sharedData);]({{assets}}/window-shared-data.png)
