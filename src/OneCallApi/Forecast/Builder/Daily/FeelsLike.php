<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder\Daily;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Daily\FeelsLike as FeelsLikeValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class FeelsLike implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function build(array $data): FeelsLikeValue
    {
        $feelsLikeData      = $data['feels_like'];
        $feelsLike          = new FeelsLikeValue();
        $feelsLike->morning = $feelsLikeData['morn'];
        $feelsLike->day     = $feelsLikeData['day'];
        $feelsLike->evening = $feelsLikeData['eve'];
        $feelsLike->night   = $feelsLikeData['night'];
        $feelsLike->unit    = $this->unit->getFromType('temperature');

        return $feelsLike;
    }
}
