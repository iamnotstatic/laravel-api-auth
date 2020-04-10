# Laravel API Auth

[![GitHub issues](https://img.shields.io/github/issues/iamnotstatic/laravel-api-auth)](https://github.com/iamnotstatic/laravel-api-auth/issues)
[![GitHub stars](https://img.shields.io/github/stars/iamnotstatic/laravel-api-auth)](https://github.com/iamnotstatic/laravel-api-auth/stargazers)
[![GitHub license](https://img.shields.io/github/license/iamnotstatic/laravel-api-auth)](https://github.com/iamnotstatic/laravel-api-auth)
[![Total Downloads](https://img.shields.io/packagist/dt/iamnotstatic/laravel-api-auth)](https://github.com/iamnotstatic/laravel-api-auth)

## Introduction

> A Laravel Package for easy API authentication setup with passport

## Installation

To get the latest version of Laravel Api Auth, simply require it

```bash
composer require iamnotstatic/laravel-api-auth
```

## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="Iamnotstatic\LaravelAPIAuth\LaravelAPIAuthServiceProvider"
```

Migrate your database after installing the package

```bash
php artisan migrate
```

This command will create the encryption keys needed to generate secure access tokens. In addition, the command will create "personal access" and "password grant" clients which will be used to generate access tokens

```bash
php artisan passport:install
```

Next, you should call the Passport::routes method within the boot method of your AuthServiceProvider. This method will register the routes necessary to issue access tokens and revoke access tokens, clients, and personal access tokens:

```php
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
    }
}
```

In your config/auth.php configuration file, you should set the driver option of the api authentication guard to passport. This will instruct your application to use Passport's TokenGuard when authenticating incoming API requests:

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```

In your config/auth.php configuration file, you should set the model option of the package model. This will provide a few helper methods to allow you to inspect the authenticated user's token and scopes:

```php
'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => Iamnotstatic\LaravelAPIAuth\Models\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],
```

## Usage

Now, we can simple test by rest client tools (Postman), So I test it and you can see below screenshots.

> In this api you have to set two header as listed below:

```bash
Accept: application/json
```

![pkg imgs](https://user-images.githubusercontent.com/46509072/78991850-d1b2ee80-7b31-11ea-8c90-e588fe7789ab.png)

Register

![register](https://user-images.githubusercontent.com/46509072/78993042-bc8b8f00-7b34-11ea-8eb4-449c7f82fd3f.png)

Login

![login](https://user-images.githubusercontent.com/46509072/78993086-d3ca7c80-7b34-11ea-807f-8bbf7baa00e8.png)

Logout

![logout](https://user-images.githubusercontent.com/46509072/78993159-f8beef80-7b34-11ea-9f0e-bff2dda268d8.png)

Get User

![getuser](https://user-images.githubusercontent.com/46509072/78993121-e93fa680-7b34-11ea-98da-6ff837f52b78.png)

Forgotten Password

![forgottenpass](https://user-images.githubusercontent.com/46509072/78993185-0d02ec80-7b35-11ea-888b-d1ff379170c8.png)

Reset Passowrd

![passwordreset](https://user-images.githubusercontent.com/46509072/78993214-1e4bf900-7b35-11ea-9c2b-346e1f555b97.png)

## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance the functionalities.

## How can I thank you?

Why not star the github repo? I'd love the attention! Why not share the link for this repository on Twitter or HackerNews? Spread the word!

Don't forget to [follow me on twitter](https://twitter.com/iamnotstatic)!

Thanks!
Abdulfatai Suleiman.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
