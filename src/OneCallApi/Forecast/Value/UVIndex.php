<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value;

class UVIndex
{
    public float $value;

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
