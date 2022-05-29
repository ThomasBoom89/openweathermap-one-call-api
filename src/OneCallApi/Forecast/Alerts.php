<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast;

use ArrayIterator;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Alerts\Alert;

class Alerts extends ArrayIterator
{
    public function current(): Alert
    {
        return parent::current();
    }
}
