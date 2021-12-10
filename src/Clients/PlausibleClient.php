<?php

namespace DaniloPolani\FilamentPlausibleWidget\Clients;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class PlausibleClient
{
    protected PendingRequest $http;

    protected array $config;

    public function __construct()
    {
        $this->config = Config::get('filament-plausible-widget');

        $this->http = Http::baseUrl('https://plausible.io/api/v1')
            ->withToken($this->config['token']);
    }

    /**
     * Get the timeseries for a specific period.
     *
     * @param  string $period
     * @return array
     */
    public function timeseries(string $period): array
    {
        return $this->http
            ->get('/stats/timeseries', [
                'site_id' => $this->config['site_id'],
                'period' => $period,
            ])
            ->throw()
            ->json('results');
    }
}
