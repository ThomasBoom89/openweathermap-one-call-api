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
