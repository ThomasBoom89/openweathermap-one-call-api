<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Daily\Day as DayValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Timezone\Calculator;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class Day implements Builder
{
    use Calculator;

    private Sun                       $sun;
    private Moon                      $moon;
    private Builder\Daily\Temperature $temperature;
    private Builder\Daily\FeelsLike   $feelsLike;
    private Pressure                  $pressure;
    private Humidity                  $humidity;
    private DewPoint                  $dewPoint;
    private Wind                      $wind;
    private Condition                 $condition;
    private Cloudiness                $cloudiness;
    private Probability               $probability;
    private Rain                      $rain;
    private Snow                      $snow;
    private UVIndex                   $uvIndex;

    public function __construct(
        Sun                       $sun,
        Moon                      $moon,
        Builder\Daily\Temperature $temperature,
        Builder\Daily\FeelsLike   $feelsLike,
        Pressure                  $pressure,
        Humidity                  $humidity,
        DewPoint                  $dewPoint,
        Wind                      $wind,
        Condition                 $condition,
        Cloudiness                $cloudiness,
        Probability               $probability,
        Rain                      $rain,
        Snow                      $snow,
        UVIndex                   $uvIndex
    ) {
        $this->sun         = $sun;
        $this->moon        = $moon;
        $this->temperature = $temperature;
        $this->feelsLike   = $feelsLike;
        $this->pressure    = $pressure;
        $this->humidity    = $humidity;
        $this->dewPoint    = $dewPoint;
        $this->wind        = $wind;
        $this->condition   = $condition;
        $this->cloudiness  = $cloudiness;
        $this->probability = $probability;
        $this->rain        = $rain;
        $this->snow        = $snow;
        $this->uvIndex     = $uvIndex;
    }

    public function build(array $data): DayValue
    {
        $day              = new DayValue();
        $day->dateTime    = $this->getDateTime($data['dt'], $data['timezone_offset']);
        $day->sun         = $this->sun->build($data);
        $day->moon        = $this->moon->build($data);
        $day->temperature = $this->temperature->build($data);
        $day->feelsLike   = $this->feelsLike->build($data);
        $day->pressure    = $this->pressure->build($data);
        $day->humidity    = $this->humidity->build($data);
        $day->dewPoint    = $this->dewPoint->build($data);
        $day->uvIndex     = $this->uvIndex->build($data);
        $day->cloudiness  = $this->cloudiness->build($data);
        $day->wind        = $this->wind->build($data);
        $day->rain        = $this->rain->build($data);
        $day->snow        = $this->snow->build($data);
        $day->condition   = $this->condition->build($data);
        $day->probability = $this->probability->build($data);

        return $day;
    }
}
