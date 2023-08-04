<x-filament-widgets::widget>
    <x-filament::section>
        <header class="flex items-center justify-between w-full plausible-widget__mb-10">
            <h2 class="text-2xl">
                {{ __('plausible-widget::widget.header.visitors') }}
            </h2>

            @if ($periodSelectable)
                <select
                    wire:model.live="currentPeriod"
                    class="plausible-widget__select bg-white dark:bg-gray-900 border rounded shadow-sm pl-3 pr-10 py-2 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 border-gray-300 dark:border-gray-700">
                    @foreach ($periods as $periodKey => $periodName)
                        <option value="{{ $periodKey }}">{{ $periodName }}</option>
                    @endforeach
                </select>
            @endif
        </header>

        <script>const plausibleWidgetTimeseries = @json($timeseries);</script>

        <div wire:ignore x-data="{}" x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('plausible-widget', package: 'danilopolani/filament-plausible-widget'))]">
            <canvas id="plausible-widget-chart" width="100%" height="300"></canvas>
        </div>

        <footer class="flex items-center justify-between w-full plausible-widget__mt-3">
            <a href="https://plausible.io/{{ $siteId }}" target="_blank" class="text-sm hover:underline">
                {{ __('plausible-widget::widget.footer.view_more') }}
            </a>

            <p class="text-sm flex plausible-widget__justify-end">
                {{ __('plausible-widget::widget.footer.statistics_by') }} <img src="https://plausible.io/assets/images/icon/plausible_logo.compressed.png" class="h-5 ml-2" alt="Plausible logo">
            </p>
        </footer>
    </x-filament::section>
</x-filament-widgets::widget>
