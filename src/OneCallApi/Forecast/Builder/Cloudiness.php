<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Cloudiness as CloudinessValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class Cloudiness implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function build(array $data): CloudinessValue
    {
        $cloudiness        = new CloudinessValue();
        $cloudiness->value = $data['clouds'];
        $cloudiness->unit  = $this->unit->getFromType('cloudiness');

        return $cloudiness;
    }
}
