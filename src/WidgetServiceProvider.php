<?php

namespace DaniloPolani\FilamentPlausibleWidget;

use DaniloPolani\FilamentPlausibleWidget\Widgets\PlausibleWidget;
use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class WidgetServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-plausible-widget';

    /**
     * {@inheritDoc}
     */
    public function configurePackage(Package $package): void
    {
        parent::configurePackage($package);

        $package
            ->hasAssets()
            ->hasConfigFile();
    }

    /**
     * {@inheritDoc}
     */
    protected function getWidgets(): array
    {
        return [
            PlausibleWidget::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getStyles(): array
    {
        return [
            self::$name . '-styles' => '/vendor/' . self::$name . '/app.css',
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getScripts(): array
    {
        return [
            self::$name . '-scripts' => '/vendor/' . self::$name . '/app.js',
        ];
    }
}
