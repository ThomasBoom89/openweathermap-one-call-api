<?php

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Sun as SunValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Timezone\Calculator;

class Sun implements Builder
{
    use Calculator;

    /**
     * @param array{'sunrise'? : int, 'sunset'? : int, 'timezone_offset': int} $data
     */
    public function build(array $data): ?SunValue
    {
        if (!array_key_exists('sunrise', $data)
            || !array_key_exists('sunset', $data)
            || $data['sunrise'] === 0
            || $data['sunset'] === 0
        ) {
            return null;
        }
        $sun       = new SunValue();
        $sun->rise = $this->getDateTime($data['sunrise'], $data['timezone_offset']);
        $sun->set  = $this->getDateTime($data['sunset'], $data['timezone_offset']);

        return $sun;
    }
}
