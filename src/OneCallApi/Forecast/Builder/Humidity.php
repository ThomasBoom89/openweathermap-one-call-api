<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Humidity as HumidityValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class Humidity implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function build(array $data): HumidityValue
    {
        $humidity        = new HumidityValue();
        $humidity->value = $data['humidity'];
        $humidity->unit  = $this->unit->getFromType('humidity');

        return $humidity;
    }
}
