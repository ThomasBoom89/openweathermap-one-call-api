<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Temperature as TemperatureValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class FeelsLike
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function build(array $data): TemperatureValue
    {
        $temperature = new TemperatureValue();
        $temperature->value = $data['feels_like'];
        $temperature->unit = $this->unit->getFromType('temperature');

        return $temperature;
    }
}
