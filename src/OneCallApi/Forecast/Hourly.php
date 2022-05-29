<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;

use ArrayIterator;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Hourly\Hour;

class Hourly extends ArrayIterator
{
    public function current(): Hour
    {
        return parent::current();
    }
}
