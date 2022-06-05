<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast as ForecastValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

/**
 * @phpstan-import-type CurrentArray from Current
 * @phpstan-import-type MinutelyArray from Minutely
 * @phpstan-import-type HourlyArray from Hourly
 * @phpstan-import-type DailyArray from Daily
 * @phpstan-import-type AlertsArray from Alerts
 * @phpstan-type ForecastArray array{
 *     'timezone_offset' : int,
 *     'current' : CurrentArray,
 *     'minutely'? : MinutelyArray,
 *     'hourly' : HourlyArray,
 *     'daily' : DailyArray,
 *     'alerts'? : AlertsArray
 * }
 */
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

    /**
     * @noinspection PhpDocSignatureInspection
     * @param ForecastArray $data
     */
    public function build(array $data): ForecastValue
    {
        $timezone = $data['timezone_offset'];
        $forecast = new ForecastValue();

        $currentData                    = $data['current'];
        $currentData['timezone_offset'] = $timezone;
        $forecast->current              = $this->current->build($currentData);

        $minutelyData = $data['minutely'] ?? [];
        $this->minutely->setTimezone($timezone);
        $forecast->minutely = $this->minutely->build($minutelyData);

        $this->hourly->setTimezone($timezone);
        $forecast->hourly = $this->hourly->build($data['hourly']);

        $this->daily->setTimezone($timezone);
        $forecast->daily = $this->daily->build($data['daily']);

        $forecast->alerts = new ForecastValue\Alerts();
        if (array_key_exists('alerts', $data)) {
            $this->alerts->setTimezone($timezone);
            $forecast->alerts = $this->alerts->build($data['alerts']);
        }

        return $forecast;
    }
}
