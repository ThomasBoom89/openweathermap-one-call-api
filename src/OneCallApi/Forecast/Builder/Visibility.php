<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Visibility as VisibilityValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Unit;

class Visibility implements Builder
{
    private Unit $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function build(array $data): VisibilityValue
    {
        $visibility        = new VisibilityValue();
        $visibility->value = $data['visibility'];
        $visibility->unit  = $this->unit->getFromType('visibility');

        return $visibility;
    }
}
