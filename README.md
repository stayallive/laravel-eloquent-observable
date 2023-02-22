# Laravel Eloquent Observable

[![Latest Version](https://img.shields.io/github/release/stayallive/laravel-eloquent-observable.svg?style=flat-square)](https://github.com/stayallive/laravel-eloquent-observable/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/actions/workflow/status/stayallive/laravel-eloquent-observable/ci.yaml?branch=master&style=flat-square)](https://github.com/stayallive/laravel-eloquent-observable/actions/workflows/ci.yaml)
[![Total Downloads](https://img.shields.io/packagist/dt/stayallive/laravel-eloquent-observable.svg?style=flat-square)](https://packagist.org/packages/stayallive/laravel-eloquent-observable)

Register Eloquent model event listeners just-in-time directly from the model.

Using [Observers](https://laravel.com/docs/10.x/eloquent#observers) can introduce a (significant) overhead on the application since they are usually registered in a service
provider which results in every model in your application with a observer is "booted" a startup of the application even though the model is never touched in the request. This
package aims to reduce that overhead by connecting listeners just-in-time whenever the Eloquent model is booted (first used) in the request. The event callbacks are also
defined on the model itself keeping the code cleaner, althought this is my preference of course and if you disagree this might not be the package for you.

## Installation

```bash
composer require stayallive/laravel-eloquent-observable
```

## Usage

Adding the `Observable` trait will ensure that the observable events are connected to the event handlers defined on the model.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stayallive\Laravel\Eloquent\Observable\Observable;

class SomeModel extends Model
{
    use Observable;

    // Event handlers are defined by `onEventName` where `EventName` is any valid Eloquent event (or custom event)
    // See a full list of Eloquent events: https://laravel.com/docs/9.x/eloquent#events
    public static function onSaving(self $model): void
    {
        // For example:
        $model->slug = str_slug($model->title);
    }
}
```

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Alex Bouma at `alex+security@bouma.me`. All security vulnerabilities will be swiftly
addressed.

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
