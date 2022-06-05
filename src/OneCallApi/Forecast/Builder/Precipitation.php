<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Precipitation as PrecipitationValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class Precipitation implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @param array{'precipitation': float} $data
     */
    public function build(array $data): PrecipitationValue
    {
        $precipitation        = new PrecipitationValue();
        $precipitation->value = $data['precipitation'];
        $precipitation->unit  = $this->unit->getFromType('precipitation');

        return $precipitation;
    }
}
