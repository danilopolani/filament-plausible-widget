<?php

namespace Danilopolani\FilamentPlausibleWidget;

use Danilopolani\FilamentPlausibleWidget\Widgets\Plausible;
use Filament\Filament;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentPlausibleWidgetServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-plausible-widget')
            ->hasViews()
            ->hasAssets()
            ->hasConfigFile()
            ->hasTranslations();
    }

    public function bootingPackage()
    {
        Livewire::component(Plausible::getName(), Plausible::class);

        Filament::registerWidget(Plausible::class);
        Filament::registerScript($this->package->name, '/vendor/' . $this->package->name . '/app.js');
        Filament::registerStyle($this->package->name, '/vendor/' . $this->package->name . '/app.css');
    }
}
