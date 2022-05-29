<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value;

class Precipitation
{
    public float  $value;
    public string $unit;

    public function __toString(): string
    {
        return $this->value . $this->unit;
    }
}
