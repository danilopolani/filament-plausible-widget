# Filament Plausible Widget

[![Latest Version on Packagist](https://img.shields.io/packagist/v/danilopolani/filament-plausible-widget.svg?style=flat-square)](https://packagist.org/packages/danilopolani/filament-plausible-widget)
[![Total Downloads](https://img.shields.io/packagist/dt/danilopolani/filament-plausible-widget.svg?style=flat-square)](https://packagist.org/packages/danilopolani/filament-plausible-widget)

Add a fancy Plausible statistics widget to your Filament admin dashboard.

<p align="center"><img src="https://i.imgur.com/TlBBVis.png" alt="Filament Plausible Widget preview"></p>

> If you're using Filament v1, please navigate the [v1 branch](https://github.com/danilopolani/filament-plausible-widget/tree/v1.0.1).

## Installation

You can install the package via composer:

```bash
composer require danilopolani/filament-plausible-widget
```

Then publish the config of the package and the assets as well:

```bash
php artisan vendor:publish --provider="DaniloPolani\FilamentPlausibleWidget\WidgetServiceProvider"
```

Finally load the widget into your [Filament config file](https://filamentadmin.com/docs/2.x/admin/installation#publishing-the-configuration):

```php
'widgets' => [
    // ...
    'register' => [
        // ...
        \DaniloPolani\FilamentPlausibleWidget\Widgets\PlausibleWidget::class,
    ],
],
```

> If you're upgrading from v1 to v2 please note that the namespace changed from `\Danilopolani\`  to `\DaniloPolani\`.

### Upgrade
When upgrading, you may want to republish the assets:

```bash
php artisan vendor:publish --tag=filament-plausible-widget-assets --force
```

## Configuration

There are a few notable configuration options for the package.

**`token`**

Your Plausible API key. You can obtain an API key for your account by going to your user settings page https://plausible.io/settings.  

**`site_id`**

The site ID you want to get statistics of. You can obtain this value by navigating to your site settings in Plausible and grab the "value" of the domain field. E.g. `plausible.io/mysite.com` becomes `mysite.com`.  

**`periods.default`** (Default: `7d`)

The period shown by default in the dashboard. Can be any of these values: `day`, `7d`, `30d`, `month`, `6mo`, `12mo`.  

**`periods.selectable`** (Default: `true`)

Choose if let users select a different period of statistics in the dashboard.  

**`cache.enabled`** (<u>**Recommended**</u>) (Default: `true`)

Cache the statistics to avoid API calls for a specific amount of time.

**`cache.ttl`**  

If cache is enabled, define for how long the statistics are stored in the cache.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email danilo.polani@gmail.com instead of using the issue tracker.

## Credits

- [Danilo Polani](https://github.com/danilopolani)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
