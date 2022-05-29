<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\DewPoint as DewPointValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class DewPoint implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function build(array $data): DewPointValue
    {
        $dewPoint        = new DewPointValue();
        $dewPoint->value = $data['dew_point'];
        $dewPoint->unit  = $this->unit->getFromType('temperature');

        return $dewPoint;
    }
}
