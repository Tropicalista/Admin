# Admin

[![Build Status](https://travis-ci.org/tropicalista/admin.svg?branch=master)](https://travis-ci.org/tropicalista/admin)
[![styleci](https://styleci.io/repos/CHANGEME/shield)](https://styleci.io/repos/CHANGEME)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tropicalista/admin/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tropicalista/admin/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/CHANGEME/mini.png)](https://insight.sensiolabs.com/projects/CHANGEME)
[![Coverage Status](https://coveralls.io/repos/github/tropicalista/admin/badge.svg?branch=master)](https://coveralls.io/github/tropicalista/admin?branch=master)

[![Packagist](https://img.shields.io/packagist/v/tropicalista/admin.svg)](https://packagist.org/packages/tropicalista/admin)
[![Packagist](https://poser.pugx.org/tropicalista/admin/d/total.svg)](https://packagist.org/packages/tropicalista/admin)
[![Packagist](https://img.shields.io/packagist/l/tropicalista/admin.svg)](https://packagist.org/packages/tropicalista/admin)

Package description: CHANGE ME

## Installation

Install via composer
```bash
composer require tropicalista/admin
```

### Register Service Provider

**Note! This and next step are optional if you use laravel>=5.5 with package
auto discovery feature.**

Add service provider to `config/app.php` in `providers` section
```php
Tropicalista\Admin\ServiceProvider::class,
```

### Register Facade

Register package facade in `config/app.php` in `aliases` section
```php
Tropicalista\Admin\Facades\Admin::class,
```

### Publish Configuration File

```bash
php artisan vendor:publish --provider="Tropicalista\Admin\ServiceProvider" --tag="config"
```

## Usage

CHANGE ME

## Security

If you discover any security related issues, please email francescopepe@email.it
instead of using the issue tracker.

## Credits

- [Francesco Pepe](https://github.com/tropicalista/admin)
- [All contributors](https://github.com/tropicalista/admin/graphs/contributors)

This package is bootstrapped with the help of
[melihovv/laravel-package-generator](https://github.com/melihovv/laravel-package-generator).
