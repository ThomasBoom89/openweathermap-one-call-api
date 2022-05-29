<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value;

use DateTime;

class Moon
{
    public DateTime $rise;
    public DateTime $set;
    public float    $phase;
}
