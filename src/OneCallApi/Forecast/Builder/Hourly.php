<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Hourly as HourlyValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Timezone;

/**
 * @phpstan-type HourlyArray array<int, array{
 *      'dt' : int, 'timezone_offset' : int,
 *      'temp' : float,
 *      'feels_like' : float,
 *      'pressure': int,
 *      'humidity': int,
 *      'dew_point': float,
 *      'uvi' : float,
 *      'clouds': int,
 *      'visibility' : int,
 *      'wind_speed': float, 'wind_deg': int, 'wind_gust': float,
 *      'rain'?: float|array{'1h': float},
 *      'snow'?: float|array{'1h': float},
 *       'weather': array{
 *          array{
 *              'id': int,
 *              'main': string,
 *              'description': string,
 *              'icon': string
 *          }
 *      },
 *      'pop': float
 * }>
 */
class Hourly implements Builder, Timezone
{
    private Hour $hour;
    private int  $timezone;

    public function __construct(Hour $hour)
    {
        $this->hour = $hour;
    }

    /**
     * @noinspection PhpDocSignatureInspection
     * @param HourlyArray $data
     */
    public function build(array $data): HourlyValue
    {
        $hours = [];
        foreach ($data as $item) {
            $item['timezone_offset'] = $this->timezone;
            $hours[]                 = $this->hour->build($item);
        }

        return new HourlyValue($hours);
    }

    public function setTimezone(int $timezone): void
    {
        $this->timezone = $timezone;
    }
}
