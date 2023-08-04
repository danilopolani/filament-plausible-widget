<?php

namespace DaniloPolani\FilamentPlausibleWidget;

use DaniloPolani\FilamentPlausibleWidget\Widgets\PlausibleWidget;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WidgetServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-plausible-widget';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews()
            ->hasTranslations()
            ->hasConfigFile();
    }

    public function packageBooted(): void
    {
        Livewire::component('plausible-widget', PlausibleWidget::class);

        FilamentAsset::register(
            assets: [
                Css::make('plausible-widget', __DIR__ . '/../resources/dist/app.css'),
                Js::make('plausible-widget', __DIR__ . '/../resources/dist/app.js')->loadedOnRequest(),
            ],
            package: 'danilopolani/filament-plausible-widget'
        );
    }
}
