<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;

use ArrayIterator;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Hourly\Hour;

/**
 * @extends ArrayIterator<int, Hour>
 */
class Hourly extends ArrayIterator
{
    public function current(): Hour
    {
        return parent::current();
    }
}
