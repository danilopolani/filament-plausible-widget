<?php

namespace Danilopolani\FilamentPlausibleWidget\Widgets;

use Danilopolani\FilamentPlausibleWidget\Clients\Plausible as PlausibleClient;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Plausible extends Widget
{
    public static $view = 'filament-plausible-widget::widgets.plausible';
    public string $currentPeriod;
    public array $periods;
    public bool $periodSelectable;

    protected array $config;

    public function mount()
    {
        $this->currentPeriod = Config::get('filament-plausible-widget.periods.default');
        $this->periodSelectable = Config::get('filament-plausible-widget.periods.selectable');
        $this->periods = [
            'day' => __('filament-plausible-widget::widget.periods.today'),
            '7d' => __('filament-plausible-widget::widget.periods.last_week'),
            '30d' => __('filament-plausible-widget::widget.periods.last_30_days'),
            'month' => __('filament-plausible-widget::widget.periods.this_month'),
            '6mo' => __('filament-plausible-widget::widget.periods.last_6_months'),
            '12mo' => __('filament-plausible-widget::widget.periods.last_12_months'),
        ];
    }

    public function render()
    {
        /** @var array $timeseries */
        $plausibleData = Config::get('filament-plausible-widget.cache.enabled')
            ? Cache::remember('filament-plausible-widget:' . $this->currentPeriod, now()->add(Config::get('filament-plausible-widget.cache.ttl')), fn () => $this->getTimeseries())
            : $this->getTimeseries();

        $data = Collection::make($plausibleData)
            ->mapWithKeys(fn (array $item) => [$item['date'] => $item['visitors']]);

        $timeseries = [
            'labels' => $data->keys()->map(fn (string $date) => $this->formatDate($date))->all(),
            'data' => $data->values()->all(),
        ];

        $this->emit('plausibleWidgetUpdated', $timeseries);

        return view(static::$view, [
            'siteId' => Config::get('filament-plausible-widget.site_id'),
            'timeseries' => $timeseries,
        ]);
    }

    protected function getTimeseries(): array
    {
        return (new PlausibleClient())->timeseries($this->currentPeriod);
    }

    protected function formatDate(string $date): string
    {
        $formats = [
            'day' => 'ga',
            '6mo' => 'F',
            '12mo' => 'F',
        ];

        return (new Carbon($date))->format($formats[$this->currentPeriod] ?? 'D, j M');
    }
}
