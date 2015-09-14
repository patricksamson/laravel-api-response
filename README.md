# laravel-api-response

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A Laravel wrapper for thephpleague's Fractal package

## Install

Via Composer

``` bash
composer require lykegenes/laravel-api-response
```

Then, add this to your Service Providers :
``` php
Lykegenes\ApiResponse\ServiceProvider::class,
```

...and this to your Aliases :
``` php
'ApiResponse' => Lykegenes\ApiResponse\Facades\ApiResponse::class,
```

Optionally, you can publish and edit the configuration file :
``` bash
php artisan vendor:publish --provider="Lykegenes\ApiResponse\ServiceProvider" --tag=config
```

## Usage

The easiest way to use this package is to call the **make()** function from the facade.
It will try to guess your input. For the transformers, see the docs from the Fractal package [here](http://fractal.thephpleague.com/transformers/).
``` php
// You can use a class directly to return a paginated collection
return ApiResponse::make(User::class, UserTransformer::class);

// You can also use an Eloquent Query
return ApiResponse::make(User::where('age', '<', '40'), UserTransformer::class);

// This will return a single object
return ApiResponse::make(User::findOrFail($id), UserTransformer::class);
```

## Testing

``` bash
composer test
```

## Credits

- [Patrick Samson][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/lykegenes/laravel-api-response.svg?style=flat-square
[ico-license]: https://img.shields.io/packagist/l/lykegenes/laravel-api-response.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Lykegenes/laravel-api-response/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/lykegenes/laravel-api-response.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/lykegenes/laravel-api-response.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/lykegenes/laravel-api-response.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/lykegenes/laravel-api-response
[link-travis]: https://travis-ci.org/Lykegenes/laravel-api-response
[link-scrutinizer]: https://scrutinizer-ci.com/g/lykegenes/laravel-api-response/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/lykegenes/laravel-api-response
[link-downloads]: https://packagist.org/packages/lykegenes/laravel-api-response
[link-author]: https://github.com/lykegenes
[link-contributors]: ../../contributors
