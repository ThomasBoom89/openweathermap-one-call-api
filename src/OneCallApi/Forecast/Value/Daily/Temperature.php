<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Daily;

class Temperature
{
    public float  $morning;
    public float  $day;
    public float  $evening;
    public float  $night;
    public float  $min;
    public float  $max;
    public string $unit;
}
