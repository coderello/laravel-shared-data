---
title: Installation
section: Getting Started
weight: 200
featherIcon: download
---

You can install this package via composer using this command:

```bash
composer require coderello/laravel-shared-data 
```

To publish the config file to `config/shared-data.php` run:

```bash
php artisan vendor:publish --provider="Coderello\SharedData\Providers\SharedDataServiceProvider" --tag="config"
```
