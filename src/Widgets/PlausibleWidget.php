<?php

namespace DaniloPolani\FilamentPlausibleWidget\Widgets;

use DaniloPolani\FilamentPlausibleWidget\Clients\PlausibleClient;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class PlausibleWidget extends Widget
{
    /**
     * Currently selected period.
     *
     * @var string
     */
    public string $currentPeriod;

    /**
     * Available periods to select.
     *
     * @var array
     */
    public array $periods;

    /**
     * Determine if a user can select a different period.
     *
     * @var bool
     */
    public bool $periodSelectable;

    /**
     * Plausible configuration.
     *
     * @var array
     */
    protected array $config;

    /**
     * Widget view name.
     *
     * @var string
     */
    protected static string $view = 'filament-plausible-widget::widgets.plausible';

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     */
    public function render(): View
    {
        /** @var array $timeseries */
        $plausibleData = [];

        if (Config::get('filament-plausible-widget.cache.enabled')) {
            $plausibleData = Cache::remember(
                'filament-plausible-widget:' . $this->currentPeriod,
                Carbon::now()->add(Config::get('filament-plausible-widget.cache.ttl')),
                fn () => $this->getTimeseries()
            );
        } else {
            $plausibleData = $this->getTimeseries();
        }

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

    /**
     * Get timeseries for the current selected period.
     *
     * @return array
     */
    protected function getTimeseries(): array
    {
        return (new PlausibleClient())->timeseries($this->currentPeriod);
    }

    /**
     * Format the date for the current selected period.
     *
     * @param  string $date
     * @return string
     */
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
