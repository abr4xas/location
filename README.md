# Import states > cities > neighborhood

[![Latest Version on Packagist](https://img.shields.io/packagist/v/abr4xas/location.svg?style=flat-square)](https://packagist.org/packages/abr4xas/location)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/abr4xas/location/run-tests?label=tests)](https://github.com/abr4xas/location/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/abr4xas/location.svg?style=flat-square)](https://packagist.org/packages/abr4xas/location)


Import states > cities > neighborhood from specific country.


## Installation

You can install the package via composer:

```bash
composer require abr4xas/location
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Abr4xas\Location\LocationServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the model files with:
```bash
php artisan vendor:publish --provider="Abr4xas\Location\LocationServiceProvider" --tag="models"
```

## Usage

``` php
php artisan import:states-from {country=AR}
php artisan import:cities
php artisan import:neighborhoods
```

country list

```
country: AR,
name: Argentina,
country: BO,
name: Bolivia,
country: BR,
name: Brasil,
country: CL,
name: Chile,
country: CN,
name: China,
country: CO,
name: Colombia,
country: CR,
name: Costa Rica,
country: CBT,
name: Cross Border Trade,
country: EC,
name: Ecuador,
country: SV,
name: El Salvador,
country: GT,
name: Guatemala,
country: HN,
name: Honduras,
country: MX,
name: Mexico,
country: NI,
name: Nicaragua,
country: PA,
name: Panamá,
country: PY,
name: Paraguay,
country: PE,
name: Peru,
country: PT,
name: Portugal,
country: PR,
name: Puerto Rico,
country: GB,
name: Reino Uncountryo,
country: DO,
name: República Dominicana,
country: UY,
name: Uruguay,
country: VE,
name: Venezuela,
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [angel cruz](https://github.com/abr4xas)
- [All Contributors](../../contributors)

> I'm using Mercado Libre API for this package. Kudos to all MeLi devs <3

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
