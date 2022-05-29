<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;

use ArrayIterator;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Minutely\Minute;

class Minutely extends ArrayIterator
{
    public function current(): Minute
    {
        return parent::current();
    }
}
