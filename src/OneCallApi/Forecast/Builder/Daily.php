<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Daily as DailyValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Timezone;

/**
 * @phpstan-type DailyArray array<int, array{
 *      'timezone_offset' : int,
 *      'dt' : int,
 *      'sunrise'? : int, 'sunset'? : int,
 *      'moonrise'? : int, 'moonset'? : int, 'moon_phase' : int,
 *      'temp' : array{
 *          'morn': float,
 *          'day': float,
 *          'eve': float,
 *          'night': float,
 *          'min': float,
 *          'max': float
 *      },
 *      'feels_like' : array{
 *          'morn': float,
 *          'day': float,
 *          'eve': float,
 *          'night': float
 *      },
 *      'pressure': int,
 *      'humidity': int,
 *      'dew_point': float,
 *      'uvi' : float,
 *      'clouds': int,
 *      'wind_speed': float, 'wind_deg': int, 'wind_gust': float,
 *      'rain'?: float|array{'1h': float},
 *      'snow'?: float|array{'1h': float},
 *      'weather': array{
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
class Daily implements Builder, Timezone
{
    private Day $day;
    private int $timezone;

    public function __construct(Day $day)
    {
        $this->day = $day;
    }

    /**
     * @noinspection PhpDocSignatureInspection
     * @param DailyArray $data
     */
    public function build(array $data): DailyValue
    {
        $days = [];
        foreach ($data as $item) {
            $item['timezone_offset'] = $this->timezone;
            $days[]                  = $this->day->build($item);
        }

        return new DailyValue($days);
    }

    public function setTimezone(int $timezone): void
    {
        $this->timezone = $timezone;
    }
}
