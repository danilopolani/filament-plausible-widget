<?php

namespace DaniloPolani\FilamentPlausibleWidget\Widgets;

use DaniloPolani\FilamentPlausibleWidget\Clients\PlausibleClient;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\HtmlString;

class PlausibleWidget extends ChartWidget
{
    protected static ?string $pollingInterval = null;

    public function mount(): void
    {
        parent::mount();

        $this->filter = Config::get('filament-plausible-widget.periods.default');
    }

    public function getHeading(): string
    {
        return __('filament-plausible-widget::widget.header.visitors');
    }

    public function getDescription(): string|Htmlable|null
    {
        return new HtmlString(sprintf(
            '<a href="'.config("filament-plausible-widget.host").'"/%s" target="_blank" class="text-primary-600 dark:text-primary-400">%s %s</a>',
            Config::get('filament-plausible-widget.site_id'),
            __('filament-plausible-widget::widget.footer.view_more'),
            svg('heroicon-o-arrow-top-right-on-square', 'w-3 h-3 inline-block')->toHtml(),
        ));
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'day' => __('filament-plausible-widget::widget.periods.today'),
            '7d' => __('filament-plausible-widget::widget.periods.last_week'),
            '30d' => __('filament-plausible-widget::widget.periods.last_30_days'),
            'month' => __('filament-plausible-widget::widget.periods.this_month'),
            '6mo' => __('filament-plausible-widget::widget.periods.last_6_months'),
            '12mo' => __('filament-plausible-widget::widget.periods.last_12_months'),
        ];
    }

    protected function getData(): array
    {
        /** @var array $timeseries */
        $plausibleData = [];

        if (Config::get('filament-plausible-widget.cache.enabled')) {
            $plausibleData = Cache::remember(
                'filament-plausible-widget:' . $this->filter,
                Carbon::now()->add(Config::get('filament-plausible-widget.cache.ttl')),
                fn () => $this->getTimeseries()
            );
        } else {
            $plausibleData = $this->getTimeseries();
        }

        $data = Collection::make($plausibleData)
            ->mapWithKeys(fn (array $item) => [$item['date'] => $item['visitors']]);

        return [
            'datasets' => [
                [
                    'label' => 'Views',
                    'data' => $data->values()->all(),
                    'borderWidth' => 3,
                    'borderColor' => 'rgb(101, 116, 205)',
                    'pointBackgroundColor' => 'rgb(101, 116, 205)',
                    'backgroundColor' => 'rgba(101, 116, 205, .2)',
                ],
            ],
            'labels' => $data->keys()->map(fn (string $date) => $this->formatDate($date))->all(),
        ];
    }

    /**
     * Get timeseries for the current selected period.
     *
     * @return array
     */
    protected function getTimeseries(): array
    {
        $this->filter ??= Config::get('filament-plausible-widget.periods.default');

        return (new PlausibleClient())->timeseries($this->filter);
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

        return (new Carbon($date))->format($formats[$this->filter] ?? 'D, j M');
    }
}
