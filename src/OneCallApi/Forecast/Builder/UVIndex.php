<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\UVIndex as UVIndexValue;

class UVIndex implements Builder
{
    /**
     * @param array{'uvi' : float} $data
     */
    public function build(array $data): UVIndexValue
    {
        $uvIndex        = new UVIndexValue();
        $uvIndex->value = $data['uvi'];

        return $uvIndex;
    }
}
