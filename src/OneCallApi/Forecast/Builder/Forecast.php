<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast as ForecastValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

class Forecast implements Builder
{
    private Current  $current;
    private Minutely $minutely;
    private Hourly   $hourly;
    private Daily    $daily;
    private Alerts   $alerts;

    public function __construct(Current $current, Minutely $minutely, Hourly $hourly, Daily $daily, Alerts $alerts)
    {
        $this->current  = $current;
        $this->minutely = $minutely;
        $this->hourly   = $hourly;
        $this->daily    = $daily;
        $this->alerts   = $alerts;
    }

    public function build(array $data): ForecastValue
    {
        $forecast = new ForecastValue();

        $currentData                    = $data['current'];
        $currentData['timezone_offset'] = $data['timezone_offset'];
        $forecast->current              = $this->current->build($currentData);

        $minutelyData                    = $data['minutely'] ?? [];
        $minutelyData['timezone_offset'] = $data['timezone_offset'];
        $forecast->minutely              = $this->minutely->build($minutelyData);

        $hourlyData                    = $data['hourly'];
        $hourlyData['timezone_offset'] = $data['timezone_offset'];
        $forecast->hourly              = $this->hourly->build($hourlyData);

        $dailyData                    = $data['daily'];
        $dailyData['timezone_offset'] = $data['timezone_offset'];
        $forecast->daily              = $this->daily->build($dailyData);

        $forecast->alerts = new ForecastValue\Alerts();
        if (array_key_exists('alerts', $data)) {
            $alertsData                    = $data['alerts'];
            $alertsData['timezone_offset'] = $data['timezone_offset'];
            $forecast->alerts              = $this->alerts->build($alertsData);
        }

        return $forecast;
    }
}
