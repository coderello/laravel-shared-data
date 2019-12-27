<p align="center">
  <img src="https://coderello.com/images/packages/laravel-shared-data.png" width="380" alt="Laravel Shared Data" />
</p>

## ✨ Introduction

**Laravel Shared Data** provides an easy way to share the data from your backend to the JavaScript.

## 📖 Documentation

You'll find the documentation **[here](https://coderello.com/docs/laravel-shared-data/1.0/installation)**.

## 🚀 Quick start

-   Install the package:
    ```bash
    composer require coderello/laravel-shared-data
    ```

-   Include the `@shared` directive into your blade layout before all scripts.

-   Share the data:
    ```bash
    share(['user' => $user]);
    ```
    
-   Access the variable from the JavaScript:
    ```bash
    const user = window.sharedData.user;
    ```

## 💖 Support the development

**Do you like this project? Support it by donating:**

- Patreon: [Donate](https://patreon.com/coderello)

**Laravel Shared Data** is open-sourced software licensed under the [MIT license](LICENSE.md).