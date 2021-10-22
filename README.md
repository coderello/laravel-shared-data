# Laravel Shared Data

## ✨ Introduction

**Laravel Shared Data** provides an easy way to share the data from your backend to the JavaScript.

## 🚀 Quick start

-   Install the package:
    ```bash
    composer require coderello/laravel-shared-data
    ```

-   Include the `@shared` directive into your blade layout before all scripts.

-   Share the data from within Laravel:
    ```bash
    share(['user' => $user, 'title' => $title]);
    ```
    
-   Access the data from the JavaScript directly:
    ```bash
    const user = window.sharedData.user;
    const title = window.sharedData.title;
    ```
    
-   Or using the built-it global helper:
    ```bash
    const user = shared('user');
    const title = shared('title');
    ```

## 📖 License

**Laravel Shared Data** is open-sourced software licensed under the [MIT license](LICENSE.md).
