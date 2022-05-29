<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Daily;

class FeelsLike
{
    public float  $morning;
    public float  $day;
    public float  $evening;
    public float  $night;
    public string $unit;
}
