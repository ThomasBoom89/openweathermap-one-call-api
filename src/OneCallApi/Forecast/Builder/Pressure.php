<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Pressure as PressureValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class Pressure implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function build(array $data): PressureValue
    {
        $pressure        = new PressureValue();
        $pressure->value = $data['pressure'];
        $pressure->unit  = $this->unit->getFromType('pressure');

        return $pressure;
    }
}
