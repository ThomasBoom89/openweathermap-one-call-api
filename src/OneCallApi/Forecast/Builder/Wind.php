<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Wind as WindValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class Wind implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @param array{'wind_speed': float, 'wind_deg': int, 'wind_gust': float} $data
     */
    public function build(array $data): WindValue
    {
        $wind                = new WindValue();
        $wind->speed         = $data['wind_speed'];
        $wind->speedUnit     = $this->unit->getFromType('speed');
        $wind->direction     = $data['wind_deg'];
        $wind->directionUnit = $this->unit->getFromType('degree');
        $wind->gust          = $data['wind_gust'];
        $wind->gustUnit      = $this->unit->getFromType('gust');

        return $wind;
    }
}
