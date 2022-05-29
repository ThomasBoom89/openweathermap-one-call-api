<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Hourly\Hour as HourValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Timezone\Calculator;

class Hour implements Builder
{
    use Calculator;

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
    private Probability $probability;

    public function __construct(
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
        Condition   $condition,
        Probability $probability
    ) {
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
        $this->probability = $probability;
    }

    public function build(array $data): HourValue
    {
        $hour              = new HourValue();
        $hour->dateTime    = $this->getDateTime($data['dt'], $data['timezone_offset']);
        $hour->temperature = $this->temperature->build($data);
        $hour->feelsLike   = $this->feelsLike->build($data);
        $hour->pressure    = $this->pressure->build($data);
        $hour->humidity    = $this->humidity->build($data);
        $hour->dewPoint    = $this->dewPoint->build($data);
        $hour->uvIndex     = $this->uvIndex->build($data);
        $hour->cloudiness  = $this->cloudiness->build($data);
        $hour->visibility  = $this->visibility->build($data);
        $hour->wind        = $this->wind->build($data);
        $hour->rain        = $this->rain->build($data);
        $hour->snow        = $this->snow->build($data);
        $hour->condition   = $this->condition->build($data);
        $hour->probability = $this->probability->build($data);

        return $hour;
    }
}
