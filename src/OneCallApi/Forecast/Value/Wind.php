<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value;

class Wind
{
    public float  $speed;
    public string $speedUnit;
    public int    $direction;
    public string $directionUnit;
    public float  $gust;
    public string $gustUnit;
}
