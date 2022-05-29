<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value;

class Cloudiness
{
    public int    $value;
    public string $unit;

    public function __toString(): string
    {
        return $this->value . $this->unit;
    }
}
