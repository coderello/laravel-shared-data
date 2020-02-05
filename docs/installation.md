---
title: Installation
section: Getting Started
weight: 5000
featherIcon: download
---

You can install this package via composer using this command:

```bash
composer require coderello/laravel-shared-data 
```

After the installation you need to include `@shared` directive into your blade layout before all `<script>` tags.

![@shared directive]({{assets}}/shared-directive.png)

## Publishing the config

To publish the config file to `config/shared-data.php` run:

```bash
php artisan vendor:publish --provider="Coderello\SharedData\Providers\SharedDataServiceProvider" --tag="config"
```
