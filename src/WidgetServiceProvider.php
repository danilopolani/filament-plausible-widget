<?php

namespace DaniloPolani\FilamentPlausibleWidget;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WidgetServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-plausible-widget';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasTranslations()
            ->hasConfigFile();
    }
}
