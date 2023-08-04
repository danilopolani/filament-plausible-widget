# Filament Plausible Widget

[![Latest Version on Packagist](https://img.shields.io/packagist/v/danilopolani/filament-plausible-widget.svg?style=flat-square)](https://packagist.org/packages/danilopolani/filament-plausible-widget)
[![Total Downloads](https://img.shields.io/packagist/dt/danilopolani/filament-plausible-widget.svg?style=flat-square)](https://packagist.org/packages/danilopolani/filament-plausible-widget)

Add a fancy Plausible statistics widget to your Filament admin dashboard.

<p align="center"><img src="https://i.imgur.com/TlBBVis.png" alt="Filament Plausible Widget preview"></p>

> If you're using Filament v1, please navigate the [1.x branch](https://github.com/danilopolani/filament-plausible-widget/tree/1.x).

## Installation

You can install the package via composer:

```bash
composer require danilopolani/filament-plausible-widget
```

Then publish the assets of the package:

```bash
php artisan vendor:publish --tag=filament-plausible-widget-assets
```

> If you're upgrading from v1 to v2 please note that the namespace changed from `\Danilopolani\`  to `\DaniloPolani\`.

### Filament v3

To properly see the widget in Filament v3, open your `AdminPanelProvider` file and add the widget in the `->widgets()` array:

```php
use DaniloPolani\FilamentPlausibleWidget\Widgets\PlausibleWidget;

->widgets([
    Widgets\AccountWidget::class,
    Widgets\FilamentInfoWidget::class,
    PlausibleWidget::class,
])
```

### Upgrade
When upgrading, you may want to republish the assets:

```bash
php artisan vendor:publish --tag=filament-plausible-widget-assets --force
```

## Configuration

You need only two env variables to display your Plausible widget:

| Env | Description |
| --- | --- |
| `FILAMENT_PLAUSIBLE_TOKEN` | Your Plausible API key. [Read more »](#token) |
| `FILAMENT_PLAUSIBLE_SITE_ID` | The site ID you want to get statistics of.  [Read more »](#site_id) |

----

If you want to go deeper you can publish the configuration file:

```bash
php artisan vendor:publish --tag=filament-plausible-widget-config
```

There are a few notable configuration options for the package.

### **`token`**

Your Plausible API key. You can obtain an API key for your account by going to your user settings page https://plausible.io/settings.  

### **`site_id`**

The site ID you want to get statistics of. You can obtain this value by navigating to your site settings in Plausible and grab the "value" of the domain field. E.g. `plausible.io/mysite.com` becomes `mysite.com`.  

### **`periods.default`**

The period shown by default in the dashboard. Can be any of these values: `day`, `7d`, `30d`, `month`, `6mo`, `12mo`. Default: `7d`.

### **`periods.selectable`**

Choose if let users select a different period of statistics in the dashboard. Default: `true`.

### **`cache.enabled`**
<u>**Recommended**</u>

Cache the statistics to avoid API calls for a specific amount of time. Default: `true`.

### **`cache.ttl`**  

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
