<?php

/*
 * This file is part of Openweathermap One Call Api.
 *
 * (c) ThomasBoom89 <51998416+ThomasBoom89@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Current as CurrentValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Timezone\Calculator;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 * @phpstan-type CurrentArray array{
 *      'timezone_offset' : int,
 *      'dt' : int,
 *      'sunrise'? : int, 'sunset'? : int,
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
 *      'weather': array{
 *          array{
 *              'id': int,
 *              'main': string,
 *              'description': string,
 *              'icon': string
 *          }
 *      }
 * }
 */
class Current implements Builder
{
    use Calculator;

    private Sun         $sun;
    private Temperature $temperature;
    private FeelsLike   $feelsLike;
    private Pressure    $pressure;
    private Humidity    $humidity;
    private DewPoint    $dewPoint;
    private UVIndex     $uvIndex;
    private Visibility  $visibility;
    private Wind        $wind;
    private Rain        $rain;
    private Snow        $snow;
    private Condition   $condition;
    private Cloudiness  $cloudiness;

    public function __construct(
        Sun         $sun,
        Temperature $temperature,
        FeelsLike   $feelsLike,
        Pressure    $pressure,
        Humidity    $humidity,
        DewPoint    $dewPoint,
        UVIndex     $uvIndex,
        Cloudiness  $cloudiness,
        Visibility  $visibility,
        Wind        $wind,
        Rain        $rain,
        Snow        $snow,
        Condition   $condition
    ) {
        $this->sun         = $sun;
        $this->temperature = $temperature;
        $this->feelsLike   = $feelsLike;
        $this->pressure    = $pressure;
        $this->humidity    = $humidity;
        $this->dewPoint    = $dewPoint;
        $this->uvIndex     = $uvIndex;
        $this->cloudiness  = $cloudiness;
        $this->visibility  = $visibility;
        $this->wind        = $wind;
        $this->rain        = $rain;
        $this->snow        = $snow;
        $this->condition   = $condition;
    }

    /**
     * @noinspection PhpDocSignatureInspection
     * @param CurrentArray $data
     */
    public function build(array $data): CurrentValue
    {
        $current              = new CurrentValue();
        $current->dateTime    = $this->getDateTime($data['dt'], $data['timezone_offset']);
        $current->sun         = $this->sun->build($data);
        $current->temperature = $this->temperature->build($data);
        $current->feelsLike   = $this->feelsLike->build($data);
        $current->pressure    = $this->pressure->build($data);
        $current->humidity    = $this->humidity->build($data);
        $current->dewPoint    = $this->dewPoint->build($data);
        $current->uvIndex     = $this->uvIndex->build($data);
        $current->cloudiness  = $this->cloudiness->build($data);
        $current->visibility  = $this->visibility->build($data);
        $current->wind        = $this->wind->build($data);
        $current->rain        = $this->rain->build($data);
        $current->snow        = $this->snow->build($data);
        $current->condition   = $this->condition->build($data);

        return $current;
    }
}
