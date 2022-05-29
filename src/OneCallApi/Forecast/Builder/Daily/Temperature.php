<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Daily;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Daily\Temperature as TemperatureValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class Temperature implements Builder
{

    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function build(array $data): TemperatureValue
    {
        $temperatureData      = $data['temp'];
        $temperature          = new TemperatureValue();
        $temperature->morning = $temperatureData['morn'];
        $temperature->day     = $temperatureData['day'];
        $temperature->evening = $temperatureData['eve'];
        $temperature->night   = $temperatureData['night'];
        $temperature->min     = $temperatureData['min'];
        $temperature->max     = $temperatureData['max'];
        $temperature->unit    = $this->unit->getFromType('temperature');

        return $temperature;
    }
}
