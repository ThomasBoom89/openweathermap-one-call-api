<?php

/*
 * This file is part of Openweathermap One Call Api.
 *
 * (c) ThomasBoom89 <51998416+ThomasBoom89@users.noreply.github.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;

use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Builder;
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Value\Moon as MoonValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Timezone\Calculator;

class Moon implements Builder
{
    use Calculator;

    /**
     * @param array{'moonrise'? : int, 'moonset'? : int, 'moon_phase': int, 'timezone_offset': int} $data
     */
    public function build(array $data): ?MoonValue
    {
        if (!array_key_exists('moonrise', $data)
            || !array_key_exists('moonset', $data)
            || $data['moonrise'] === 0
            || $data['moonset'] === 0
        ) {
            return null;
        }

        $moon        = new MoonValue();
        $moon->rise  = $this->getDateTime($data['moonrise'], $data['timezone_offset']);
        $moon->set   = $this->getDateTime($data['moonset'], $data['timezone_offset']);
        $moon->phase = $data['moon_phase'];

        return $moon;
    }
}
