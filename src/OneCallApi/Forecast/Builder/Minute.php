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
use Thomasboom89\OpenWeatherMap\OneCallApi\Forecast\Minutely\Minute as MinuteValue;
use Thomasboom89\OpenWeatherMap\OneCallApi\Timezone\Calculator;

class Minute implements Builder
{
    use Calculator;

    private Precipitation $precipitation;

    public function __construct(Precipitation $precipitation)
    {
        $this->precipitation = $precipitation;
    }

    /**
     * @param array{'dt': int, 'timezone_offset': int, 'precipitation': float} $data
     */
    public function build(array $data): MinuteValue
    {
        $minute                = new MinuteValue();
        $minute->precipitation = $this->precipitation->build($data);
        $minute->dateTime      = $this->getDateTime($data['dt'], $data['timezone_offset']);

        return $minute;
    }
}
