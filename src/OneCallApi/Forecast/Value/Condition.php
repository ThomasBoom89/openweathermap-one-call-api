<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value;

class Condition
{
    public int    $identifier;
    public string $main;
    public string $description;
    public string $icon;
}
