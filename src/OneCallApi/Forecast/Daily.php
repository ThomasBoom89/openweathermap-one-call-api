<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;

use ArrayIterator;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Daily\Day;

class Daily extends ArrayIterator
{
    public function current(): Day
    {
        return parent::current();
    }
}
