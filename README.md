<p align="center"><img alt="Laravel Shared Data" src="https://i.imgur.com/pzLYh8k.png" width="380"></p>

<p align="center"><b>Laravel Shared Data</b> provides an easy way to share the data from your backend to the JavaScript.</p>

[![Latest Stable Version](https://img.shields.io/packagist/v/coderello/laravel-shared-data.svg)](https://packagist.org/packages/coderello/laravel-shared-data)
[![Total Downloads](https://img.shields.io/packagist/dt/coderello/laravel-shared-data.svg)](https://packagist.org/packages/coderello/laravel-shared-data)
[![Build Status](https://travis-ci.org/coderello/laravel-shared-data.svg?branch=master)](https://travis-ci.org/coderello/laravel-shared-data)

## Installation

You can install this package via composer using this command:

```bash
composer require coderello/laravel-shared-data
```

The package will automatically register itself.

## Usage

First of all, you need to include this line before all of your `<script>` tags in you base blade layout in order to make the shared data available in all of those scripts.

```php
{!! shared()->render() !!}
```

Now you can share any data you want from any part or your application (middleware, controller, service provider etc.)

```php
use Coderello\SharedData\Facades\SharedData;

public function index()
{
    SharedData::put([
        'user' => auth()->user(),
        'post' => Post::first(),
        'username' => '@hivokas',
    ]);
    
    // or
    
    share([
        'user' => auth()->user(),
        'post' => Post::first(),
        'username' => '@hivokas',
    ]);
}
```

And get this data on the frontend side from `window.sharedData` (use can modify the namespace in the config file).

![Shared Data in JS](http://i.imgur.com/v21h7NN.png)

## Testing

You can run the tests with:

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
