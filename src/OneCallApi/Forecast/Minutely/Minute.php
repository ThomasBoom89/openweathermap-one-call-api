<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Minutely;

use DateTime;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Precipitation;

class Minute
{
    public DateTime      $dateTime;
    public Precipitation $precipitation;
}
